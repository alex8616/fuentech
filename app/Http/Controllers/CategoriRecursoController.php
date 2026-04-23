<?php

namespace App\Http\Controllers;

use App\Models\CategoriRecurso;
use App\Models\Recurso;
use App\Models\Inventario;
use App\Models\DetalleInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Traits\CambiarEstadoTurnosTrait;

class CategoriRecursoController extends Controller
{
    public function RegistrarCategoriaRecurso(Request $request){
        //return response()->json($request->PerteneceCategoria);

        $categoria = CategoriRecurso::create([
            'nombre' => $request->NombreCategoria,
            'descripcion' => $request->DescripcionCategoria,
            'pertenece' => $request->PerteneceCategoria,
        ]);

        return response()->json($categoria);
    }

    public function GetCategoriaRecurso(){
        $categoria = CategoriRecurso::get();
        return response()->json($categoria);
    }

    public function GetSeleccionadoCategoriaRecurso($id){
        $categoria = CategoriRecurso::where('id', $id)->first();
        return response()->json($categoria);
    }

    public function GetCategoriaRecursoSelect(Request $request){
        $search = $request->input('search');
    
        $categoria = CategoriRecurso::select('id', 'nombre')
            ->when($search, function($query, $search) {
                return $query->where('nombre', 'LIKE', "%$search%");
            })
            ->get();
    
        return response()->json($categoria);
    }

    public function RegistrarArticuloRecurso(Request $request) {
        //return response()->json($request);

        $articulo = Recurso::create([
            'codigo' => $request->NombreRecurso,
            'nombre' => $request->NombreRecurso,
            'descripcion' => $request->DescripcionRecurso,
            'estado' => $request->SelectEstado,
            'clasificacion' => $request->SelectClasificacion,
            'marca' => $request->MarcaRecurso,
            'observaciones' => $request->ObservacionesRecurso,
            'color' => $request->ColorRecurso,
            'categori_recursos_id' => $request->CategoriaRecursoSelect,
            'imagen' => null,
        ]);
    
        if ($request->hasFile('imagenes')) {
            $imageNames = [];
    
            foreach ($request->file('imagenes') as $imagen) {
                $imageName = time() . '_' . uniqid() . '.' . $imagen->extension();
                $imagen->move(public_path('images/inventario'), $imageName);
                $imageNames[] = $imageName;
            }
    
            $articulo->update(['imagen' => implode(',', $imageNames)]);
        }
    
        $inventario = Inventario::create([
            'fecha' => now(),
            'totalnuevo' => $request->CantidadRecurso,
            'totaldaniado' => 0,
            'totaldesechado' => 0,
            'totalperdido' => 0,
            'totalgeneral' => 0,
            'recursos_id' => $articulo->id,  
        ]);

        $detalleinventario = DetalleInventario::create([
            'descripcion' => "Creado recurso en inventario",
            'cantidad' => $request->CantidadRecurso,
            'fecha' => now(),
            'tipo' => 'entrada',
            'estado' => "Buen Estado",
            'inventarios_id' => $inventario->id,
        ]);

        $sumnuevo = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Buen Estado')->sum('cantidad');
        $sumdaniado = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Daniado')->sum('cantidad');
        $sumdesecho = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Desecho')->sum('cantidad');
        $sumperdido = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Perdido')->sum('cantidad');
        $sumtotal = $sumnuevo + $sumdaniado;
        $restatotal = $sumperdido + $sumdesecho;
        $valorfinal = $sumtotal - $restatotal;

        $inventario->totalnuevo = $sumnuevo;
        $inventario->totaldaniado = $sumdaniado;
        $inventario->totaldesechado = $sumdesecho;
        $inventario->totalperdido = $sumperdido;
        $inventario->totalingreso = $sumtotal;
        $inventario->totalsalida = $restatotal;
        $inventario->totalgeneral = $valorfinal;
        $inventario->save();

        return response()->json($articulo);
    }
    
    public function GetArticuloRecurso(){
        $articulos = Recurso::with(['categoriarecurso','inventario'])->get();
        return response()->json($articulos);
    }

    public function GetSeleccionadoArticuloRecurso($id){
        $articulo = Recurso::with(['categoriarecurso','inventario','inventario.detalleinventarios'])->where('id', $id)->first();
        return response()->json($articulo);
    }

    public function eliminarImagen(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'imagen' => 'required|string',
        ]);

        $articulo = Recurso::findOrFail($request->id);
        $imagenes = explode(',', $articulo->imagen);

        if (in_array($request->imagen, $imagenes)) {
            $path = 'images/inventario/' . $request->imagen;
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $imagenes = array_diff($imagenes, [$request->imagen]);
            $articulo->imagen = implode(',', $imagenes); 
            $articulo->save();
            return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'La imagen no se encontró'], 404);
        }
    }


    public function actualizarImagen(Request $request, $id) {
        $articulo = Recurso::findOrFail($id);
        $imagenesExistentes = $articulo->imagen ? explode(',', $articulo->imagen) : [];
    
        if ($request->hasFile('images')) {
            $nuevasImagenes = $request->file('images');
            foreach ($nuevasImagenes as $imagen) {
                $imageName = time() . '_' . uniqid() . '.' . $imagen->extension();
                $imagen->move(public_path('images/inventario'), $imageName);
                $imagenesExistentes[] = $imageName;
            }
        }
    
        $imagenesActualizadas = !empty($imagenesExistentes) ? implode(',', $imagenesExistentes) : null;
        $articulo->imagen = $imagenesActualizadas;
        $articulo->save();
    
        return response()->json($articulo);
    }
    
    public function ActualizarArticuloRecurso(Request $request) {
        $articulo = Recurso::findOrFail($request->IdUpdate);
        $articulo->nombre = $request->UpdateNombre;
        $articulo->descripcion = $request->UpdateDescripcion;
        $articulo->estado = $request->UpdateSelectEstado;
        $articulo->clasificacion = $request->UpdateSelectClasificacion;
        $articulo->marca = $request->Updatemarca;
        $articulo->observaciones = $request->Updateobservaciones;
        $articulo->color = $request->Updatecolor;
        $articulo->categori_recursos_id = $request->UpdateCategoriaRecursoSelect;

        $articulo->save();
        return response()->json($articulo);
    }

    public function RegistrarIngresoInventario(Request $request) {
        $inventario = Inventario::where('recursos_id', $request->IngresoArticuloId)->first();
        if($inventario){
            $detalleinventario = DetalleInventario::create([
                'descripcion' => $request->DescripcionIngreso,
                'cantidad' => $request->CantidadIngreso,
                'fecha' => now(),
                'tipo' => 'entrada',
                'estado' => $request->EstadoIngreso,
                'inventarios_id' => $inventario->id,
            ]);

            if($request->EstadoIngreso == "Buen Estado"){
                $inventario->totalnuevo = $request->CantidadIngreso;
                $inventario->save();
            }

            if($request->EstadoIngreso == "Daniado"){
                $inventario->totaldaniado = $request->CantidadIngreso;
                $inventario->save();
            }
        }else{
            $inventario = Inventario::create([
                'fecha' => now(),
                'totalnuevo' => 0,
                'totaldaniado' => 0,
                'totaldesechado' => 0,
                'totalperdido' => 0,
                'totalgeneral' => 0,
                'recursos_id' => $request->IngresoArticuloId,  
            ]);

            $detalleinventario = DetalleInventario::create([
                'descripcion' => $request->DescripcionIngreso,
                'cantidad' => $request->CantidadIngreso,
                'fecha' => now(),
                'tipo' => 'entrada',
                'estado' => $request->EstadoIngreso,
                'inventarios_id' => $inventario->id,
            ]);

            if($request->EstadoIngreso == "Buen Estado"){
                $inventario->totalnuevo = $request->CantidadIngreso;
                $inventario->save();
            }

            if($request->EstadoIngreso == "Daniado"){
                $inventario->totaldaniado = $request->CantidadIngreso;
                $inventario->save();
            }
        }

        $sumnuevo = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Buen Estado')->sum('cantidad');
        $sumdaniado = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Daniado')->sum('cantidad');
        $sumdesecho = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Desecho')->sum('cantidad');
        $sumperdido = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Perdido')->sum('cantidad');
        $sumtotal = $sumnuevo + $sumdaniado;
        $restatotal = $sumperdido + $sumdesecho;
        $valorfinal = $sumtotal - $restatotal;

        $inventario->totalnuevo = $sumnuevo;
        $inventario->totaldaniado = $sumdaniado;
        $inventario->totaldesechado = $sumdesecho;
        $inventario->totalperdido = $sumperdido;
        $inventario->totalingreso = $sumtotal;
        $inventario->totalsalida = $restatotal;
        $inventario->totalgeneral = $valorfinal;
        $inventario->save();

        $articulo = Recurso::where('id', $request->IngresoArticuloId)->first();
        return response()->json($articulo);
    }

    public function RegistrarSalidaInventario(Request $request) {
        $inventario = Inventario::where('recursos_id', $request->SalidaArticuloId)->first();

        if($inventario){
            $detalleinventario = DetalleInventario::create([
                'descripcion' => $request->DescripcionSalida,
                'cantidad' => $request->CantidadSalida,
                'fecha' => now(),
                'tipo' => 'salida',
                'estado' => $request->EstadoSalida,
                'inventarios_id' => $inventario->id,
            ]);

            if($request->EstadoSalida == "Desecho"){
                $inventario->totaldesechado = $request->CantidadSalida;
                $inventario->save();
            }

            if($request->EstadoSalida == "Perdido"){
                $inventario->totalperdido = $request->CantidadSalida;
                $inventario->save();
            }
        }else{
            $inventario = Inventario::create([
                'fecha' => now(),
                'totalnuevo' => 0,
                'totaldaniado' => 0,
                'totaldesechado' => 0,
                'totalperdido' => 0,
                'totalgeneral' => 0,
                'recursos_id' => $request->SalidaArticuloId,  
            ]);

            $detalleinventario = DetalleInventario::create([
                'descripcion' => $request->DescripcionSalida,
                'cantidad' => $request->CantidadSalida,
                'fecha' => now(),
                'tipo' => 'salida',
                'estado' => $request->EstadoSalida,
                'inventarios_id' => $inventario->id,
            ]);
          
            if($request->EstadoSalida == "Desecho"){
                $inventario->totaldesechado = $request->CantidadSalida;
                $inventario->save();
            }

            if($request->EstadoSalida == "Perdido"){
                $inventario->totalperdido = $request->CantidadSalida;
                $inventario->save();
            }
        }


        $sumnuevo = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Buen Estado')->sum('cantidad');
        $sumdaniado = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Daniado')->sum('cantidad');
        $sumdesecho = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Desecho')->sum('cantidad');
        $sumperdido = DetalleInventario::where('inventarios_id', $inventario->id)->where('estado', 'Perdido')->sum('cantidad');
        $sumtotal = $sumnuevo + $sumdaniado;
        $restatotal = $sumperdido + $sumdesecho;
        $valorfinal = $sumtotal - $restatotal;

        $inventario->totalnuevo = $sumnuevo;
        $inventario->totaldaniado = $sumdaniado;
        $inventario->totaldesechado = $sumdesecho;
        $inventario->totalperdido = $sumperdido;
        $inventario->totalingreso = $sumtotal;
        $inventario->totalsalida = $restatotal;
        $inventario->totalgeneral = $valorfinal;
        $inventario->save();
         
        $articulo = Recurso::where('id', $request->SalidaArticuloId)->first();
        return response()->json($articulo);
    }

    public function GetFiltroArticulos(Request $request){
        $FiltroCategoria = $request->FiltroCategoria;
        $FiltroTipo = $request->FiltroTipo;
    
        $articulos = Recurso::with(['categoriarecurso', 'inventario'])
                            ->when($FiltroCategoria !== 'Todo', function ($query) use ($FiltroCategoria) {
                                return $query->where('categori_recursos_id', $FiltroCategoria);
                            })
                            ->when($FiltroTipo !== 'Todo', function ($query) use ($FiltroTipo) {
                                return $query->whereHas('categoriarecurso', function ($query) use ($FiltroTipo) {
                                    $query->where('pertenece', $FiltroTipo);
                                });
                            })
                            ->get();
    
        return response()->json($articulos);
    }

    public function GetFiltroArticulosPDF(Request $request) {
        $FiltroCategoria = $request->FiltroCategoria;
        $FiltroTipo = $request->FiltroTipo;
    
        $articulos = Recurso::with(['categoriarecurso', 'inventario', 'inventario.detalleinventarios'])
                            ->when($FiltroCategoria !== 'Todo', function ($query) use ($FiltroCategoria) {
                                return $query->where('categori_recursos_id', $FiltroCategoria);
                            })
                            ->when($FiltroCategoria === 'Todo', function ($query) {
                                return $query->orderBy('categori_recursos_id');
                            })
                            ->get();
    
        //return view('admin.Hostal.ReporteInventarioPDF', ['articulos' => $articulos]);

        //return response()->json($articulos);

        $pdf = PDF::loadView('admin.Hostal.ReporteInventarioPDF', compact('articulos'))
                    ->setOptions(['defaultFont' => 'sans-serif'])
                    ->setPaper(array(0, 0, 595.28, 841.89), 'landscape');
    
        return $pdf->stream('Date.pdf');
    }

    public function GetFiltroArticulosPDFCompleto(Request $request) {
        $FiltroCategoria = $request->FiltroCategoria;
        $FiltroTipo = $request->FiltroTipo;
    
        $articulos = Recurso::with(['categoriarecurso', 'inventario', 'inventario.detalleinventarios'])
                            ->when($FiltroCategoria !== 'Todo', function ($query) use ($FiltroCategoria) {
                                return $query->where('categori_recursos_id', $FiltroCategoria);
                            })
                            ->when($FiltroCategoria === 'Todo', function ($query) {
                                return $query->orderBy('categori_recursos_id');
                            })
                            ->get();
    
        //return view('admin.Hostal.ReporteInventarioPDFCompleto', ['articulos' => $articulos]);

        //return response()->json($articulos);

        $pdf = PDF::loadView('admin.Hostal.ReporteInventarioPDFCompleto', compact('articulos'))
                    ->setOptions(['defaultFont' => 'sans-serif'])
                    ->setPaper(array(0, 0, 595.28, 841.89), 'portrait');
    
        return $pdf->stream('Date.pdf');
    }


    public function eliminarRecurso(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer|exists:recursos,id',
        ]);

        try {
            $recurso = Recurso::findOrFail($validated['id']);
            $recurso->delete();

            return response()->json([
                'success' => true,
                'message' => 'Recurso eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al intentar eliminar el recurso.',
            ], 500);
        }
    }
    
}
