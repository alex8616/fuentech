<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use App\Models\ArqueoCaja;
use App\Models\CuentaCorrienteProveedor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProveedoreController extends Controller
{
    public function GetProveedor(){
        $proveedores = Proveedore::get();
        return response()->json($proveedores);
    }

    public function GetProveedorList(Request $request) {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 5);
        $search = $request->input('search', '');
        
        $query = Proveedore::query();
    
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('documento', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('telefono', 'like', '%' . $search . '%')
                  ->orWhere('direccion', 'like', '%' . $search . '%');
        }
        
        $query->orderBy('id', 'desc');
        
        $proveedores = $query->paginate($limit, ['*'], 'page', $page);
        
        return response()->json($proveedores);
    }

    public function GetProveedorSeleccionado($id){
        $proveedor = Proveedore::where('id',$id)->first();
        return response()->json($proveedor);
    }

    public function RegistrarProveedor(Request $request){
        $user = Auth::user();
        if ($user) {
            $proveedor = Proveedore::create([
                'name' => $request->NombreProveedor,
                'documento' => $request->DocumentoProveedor,
                'empresa_id' => $user->empresa_id,
                'email' => $request->EmailProveedor,
                'telefono' => $request->TelefonoProveedor,
                'direccion' => $request->DireccionProveedor,
                'comentario' => $request->ComentarioProveedor,
                'estado' => $request->EstadoProveedor,
                'Total' => 0,
            ]);

            return response()->json($proveedor);
        } else {
            return response()->json("INICIA SESSION");
        }
    }

    public function GetProveedorListSelect(){
        $proveedores = Proveedore::get();
        return response()->json($proveedores);
    }

    public function RegistrarCuentaProveedor(Request $request){
        $proveedor = Proveedore::where("id",$request->Proveedor)->first();
        $user = Auth::user();

        if ($proveedor) {
            $ActivoArqueo = ArqueoCaja::where("empresa_id",$user->empresa_id)->where("Estado", "Abierto")->latest()->first();

            if($request->Arqueo == "true" && $ActivoArqueo){
                $cuentaproveedor = CuentaCorrienteProveedor::create([
                    'Tipo' => "Cobrar",
                    'Monto' => $request->Monto,
                    'MedioDePago' => $request->MedioDePago,
                    'Comentario' => $request->Comentario,
                    'Eliminado' => "false",
                    'Arqueo' => $request->Arqueo,
                    'proveedor_id' => $request->Proveedor,
                ]);
    
                if($request->MedioDePago == "Efectivo"){
                    $ActivoArqueo->Segun_SistemaEgresoEfectivo += $request->Monto;
                    $ActivoArqueo->Segun_SistemaEgresoEfectivo = number_format($ActivoArqueo->Segun_SistemaEgresoEfectivo, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotalEgreso += $request->Monto;
                    $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                    $ActivoArqueo->TotalCuentaProveedorEgresoEfectivo += $request->Monto;
                    $ActivoArqueo->TotalCuentaProveedorEgresoEfectivo = number_format($ActivoArqueo->TotalCuentaProveedorEgresoEfectivo, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotal -= $request->Monto;
                    $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
    
                    $ActivoArqueo->save();
                }
                if($request->MedioDePago == "Tarjeta"){
                    $ActivoArqueo->Segun_SistemaEgresoTarjeta += $request->Monto;
                    $ActivoArqueo->Segun_SistemaEgresoTarjeta = number_format($ActivoArqueo->Segun_SistemaEgresoTarjeta, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotalEgreso += $request->Monto;
                    $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                    $ActivoArqueo->TotalCuentaProveedorEgresoTarjeta += $request->Monto;
                    $ActivoArqueo->TotalCuentaProveedorEgresoTarjeta = number_format($ActivoArqueo->TotalCuentaProveedorEgresoTarjeta, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotal -= $request->Monto;
                    $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                    
                    $ActivoArqueo->save();  
                }
                if($request->MedioDePago == "Deposito/QR"){
                    $ActivoArqueo->Segun_SistemaEgresoDepositoQR += $request->Monto;
                    $ActivoArqueo->Segun_SistemaEgresoDepositoQR = number_format($ActivoArqueo->Segun_SistemaEgresoDepositoQR, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotalEgreso += $request->Monto;
                    $ActivoArqueo->Segun_SistemaTotalEgreso = number_format($ActivoArqueo->Segun_SistemaTotalEgreso, 2, '.', '');
                    $ActivoArqueo->TotalCuentaProveedorEgresoDepositoQR += $request->Monto;
                    $ActivoArqueo->TotalCuentaProveedorEgresoDepositoQR = number_format($ActivoArqueo->TotalCuentaProveedorEgresoDepositoQR, 2, '.', '');
                    $ActivoArqueo->Segun_SistemaTotal -= $request->Monto;
                    $ActivoArqueo->Segun_SistemaTotal = number_format($ActivoArqueo->Segun_SistemaTotal, 2, '.', '');
                    
                    $ActivoArqueo->save();
                }
                
                return response()->json($proveedor);
            }else{
                $cuentaproveedor = CuentaCorrienteProveedor::create([
                    'Tipo' => "Cobrar",
                    'Monto' => $request->Monto,
                    'MedioDePago' => $user->MedioDePago,
                    'Comentario' => $request->Comentario,
                    'Eliminado' => "false",
                    'Arqueo' => $request->Arqueo,
                    'proveedor_id' => $request->Proveedor,
                ]);
    
                return response()->json($proveedor);
            }            
        } else {
            return response()->json("INICIA SESSION");
        }
    }
    
    public function FiltrarDatosCuentaProveedor(Request $request){
        //return response()->json($request);
        $TipoProveedor = $request->input('TipoProveedor');
        $totalproveedor = 0;
        $cantidadregistrosproveedor = 0;

        $cuentas = CuentaCorrienteProveedor::with('proveedor')
                ->when($TipoProveedor !== 'Todos', function ($query) use ($TipoProveedor) {
                    return $query->where('proveedor_id', $TipoProveedor);
                })->get();

        return response()->json([
            'cuentas' => $cuentas,
            'total' => $totalproveedor,
            'cantidadregistros' => $cantidadregistrosproveedor,
        ]);
    }

    public function GetCuentaSeleccionadoProveedor($id){
        $proveedor = CuentaCorrienteProveedor::with('proveedor')->where('id',$id)->first();
        return response()->json($proveedor);
    }

    public function DeleteCuentaProveedor(Request $request){
        $user = Auth::user();
        if ($user) {
            $cuenta = CuentaCorrienteProveedor::where("id",$request->idcuenta)->first();
            $cuenta->Eliminado = "true";
            $cuenta->save();

            $proveedor = Proveedore::where("id",$cuenta->proveedor_id)->first();
            $proveedor->Total -= $cuenta->Monto;
            $proveedor->save();

            return response()->json($cuenta);
        } else {
            return response()->json("INICIA SESSION");
        }
    }
}
