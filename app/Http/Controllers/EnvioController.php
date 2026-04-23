<?php
// app/Http/Controllers/EnvioController.php

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class EnvioController extends Controller
{
    public function alcira(){
        return view('admin.alcira.vistaalcira');
    }

    public function index()
    {
        $envios = Envio::with('items')->orderBy('fecha_envio', 'desc')->get();
        return response()->json($envios);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'estado' => 'required|string',
            'donde' => 'required|string',
            'chofer' => 'required|string',
            'fecha_envio' => 'required|date',
            'producto' => 'required|array',
            'cantidad' => 'required|array',
            'producto.*' => 'required|string',
            'cantidad.*' => 'required|integer|min:1',
            'observaciones' => 'nullable|array',
            'observaciones.*' => 'nullable|string',
        ]);

        $envio = Envio::create([
            'estado' => $data['estado'],
            'donde' => $data['donde'],
            'chofer' => $data['chofer'],
            'fecha_envio' => $data['fecha_envio'],
        ]);

        foreach($data['producto'] as $key => $producto) {
            $envio->items()->create([
                'producto' => $producto,
                'cantidad' => $data['cantidad'][$key],
                'observaciones' => $data['observaciones'][$key] ?? null,
            ]);
        }

        return response()->json(['message' => 'Envío creado correctamente', 'id' => $envio->id], 201);
    }


    public function generarPDF($id){
        $envio = Envio::with('items')->findOrFail($id);

        $html = view('admin.alcira.pdf', compact('envio'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf');
    }

    public function lista(Request $request)
    {
        $query = Envio::with('items');

        if ($request->has(['dia','mes','anio'])) {
            $dia = $request->dia;
            $mes = $request->mes;
            $anio = $request->anio;

            $query->whereDay('fecha_envio', $dia)
                ->whereMonth('fecha_envio', $mes)
                ->whereYear('fecha_envio', $anio);
        }

        $envios = $query->orderBy('fecha_envio','desc')->get();

        return response()->json($envios);
    }

    public function GetEnvioSelect($id){
        $envio = Envio::with('items')->findOrFail($id);
        return response()->json($envio);
    }

    public function updateEnvio(Request $request, $id){
        // Validar campos principales
        $request->validate([
            'estado_servicioEdit' => 'required|string',
            'dondeEdit' => 'required|string',
            'choferEdit' => 'required|string',
            'fecha_envioEdit' => 'required|date',
            'items' => 'required|array',
            'items.*.producto' => 'required|string',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        // Buscar envío
        $envio = Envio::findOrFail($id);

        // Actualizar campos principales
        $envio->estado = $request->estado_servicioEdit;
        $envio->donde = $request->dondeEdit;
        $envio->chofer = $request->choferEdit;
        $envio->fecha_envio = $request->fecha_envioEdit;
        $envio->save();

        // Actualizar detalles
        // Primero eliminamos los existentes
        $envio->items()->delete();

        // Crear nuevos detalles
        foreach($request->items as $item) {
            $envio->items()->create([
                'producto' => $item['producto'],
                'cantidad' => $item['cantidad'],
                'observaciones' => $item['observaciones'] ?? null
            ]);
        }

        return response()->json(['message' => 'Envío actualizado correctamente']);
    }

    public function pdfReporte(Request $request){
        $anio = $request->anio;
        $mes  = $request->mes;
        $dia  = $request->dia;

        // Consulta
        $query = Envio::query();

        if($anio) { $query->whereYear('fecha_envio', $anio); }
        if($mes) { $query->whereMonth('fecha_envio', $mes); }
        if($dia) { $query->whereDay('fecha_envio', $dia); }

        // Traer todos los envíos filtrados con sus items
        $envios = $query->with('items')->get();

        // Renderizar la vista con todos los envíos
        $html = view('admin.alcira.pdf-reporte', compact('envios'))->render();

        // Generar PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Retornar PDF para que se abra en el navegador
        return $dompdf->stream('reporte_envios.pdf', ['Attachment' => false]);
    }

}
