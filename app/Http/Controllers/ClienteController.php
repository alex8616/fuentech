<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\CuentaCorriente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{

    public function GetCliente(Request $request) {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 5);
        $search = $request->input('search', '');
        
        $query = Cliente::query();
    
        if ($search) {
            $query->where('NombreCliente', 'like', '%' . $search . '%')
                  ->orWhere('EmailCliente', 'like', '%' . $search . '%')
                  ->orWhere('TelefonoCliente', 'like', '%' . $search . '%')
                  ->orWhere('BarrioCliente', 'like', '%' . $search . '%')
                  ->orWhere('CalleCliente', 'like', '%' . $search . '%')
                  ->orWhere('NumeroCliente', 'like', '%' . $search . '%');
        }
        
        $query->orderBy('id', 'desc');
        
        $clientes = $query->paginate($limit, ['*'], 'page', $page);
        
        return response()->json($clientes);
    }
    
    public function SearchClient(Request $request){
        $searchTerm = $request->get('search');
    
        $datacliente = Cliente::select("*", DB::raw("CONCAT(NombreCliente) as label"))
            ->where(function($query) use ($searchTerm) {
                $query->where('NombreCliente', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('TelefonoCliente', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();
    
        return response()->json($datacliente);
    }

    public function RegistrarCliente(Request $request){
        $cliente = Cliente::create([
            'NombreCliente' => $request->NombreCliente,
            'EmailCliente' => $request->EmailCliente,
            'TelefonoCliente' => $request->TelefonoCliente,
            'CalleCliente' => $request->CalleCliente,
            'NumeroCliente' => $request->NumeroCliente,
            'PisoCliente' => $request->PisoCliente,
            'BarrioCliente' => $request->BarrioCliente,
            'Comentario' => $request->Comentario,
            'MedioDePagoGasto' => $request->MedioDePagoGasto,
            'Descuento' => $request->DescuentoCliente,
            'NitDni' => $request->NitDni,
            'EstadoCliente' => $request->EstadoCliente,
            'CuentaCorrienteCliente' => "false",
        ]);

        return response()->json($cliente);
    }  
    
    public function GetClienteSeleccionado($id){
        $cliente = Cliente::where('id',$id)->first();
        return response()->json($cliente);
    }

    public function GetClienteList(Request $request) {
        $clientes = Cliente::get();
        return response()->json($clientes);
    }

    public function GetCuentaList(Request $request) {
        $cuentas = CuentaCorriente::with('cliente')->get();
        return response()->json($cuentas);
    }

    public function GetCuentaSeleccionado($id){
        $cuenta = CuentaCorriente::with('cliente')->where('id',$id)->first();
        return response()->json($cuenta);
    }

    public function RegistrarCuentaCorrienta(Request $request){
        $cliente = Cliente::find($request->Cliente);

        if ($cliente) {
            $cuenta = CuentaCorriente::create([
                'Tipo' => 'Cobro',
                'Monto' => $request->Monto,
                'MedioDePago' => $request->MedioDePago,
                'Comentario' => $request->Comentario,
                'cliente_id' => $request->Cliente,
            ]);
    
            $cliente->Total += $request->Monto;
            $cliente->save();
            
            return response()->json($cuenta, 201);
        } else {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function FiltrarDatosCuenta(Request $request){
        //return response()->json($request);
        $TipoCliente = $request->input('TipoCliente');
        $total = 0;
        $cantidadregistros = 0;

        $cuentas = CuentaCorriente::with('cliente')
                ->when($TipoCliente !== 'Todos', function ($query) use ($TipoCliente) {
                    return $query->where('cliente_id', $TipoCliente);
                })->get();

        return response()->json([
            'cuentas' => $cuentas,
            'total' => $total,
            'cantidadregistros' => $cantidadregistros,
        ]);
    }

    public function DeleteCuenta(Request $request){
        $user = Auth::user();
        if ($user) {
            $cuenta = CuentaCorriente::where("id",$request->idcuenta)->first();
            $cuenta->Eliminado = "true";
            $cuenta->save();

            $cliente = Cliente::where("id",$cuenta->cliente_id)->first();
            $cliente->Total -= $cuenta->Monto;
            $cliente->save();

            return response()->json($cuenta);
        } else {
            return response()->json("INICIA SESSION");
        }
    }    
}
