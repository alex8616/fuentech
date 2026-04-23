<?php

namespace App\Http\Controllers;

use App\Models\ClienteHostal;
use App\Models\ClienteReserva;
use Illuminate\Http\Request;

class ClienteHostalController extends Controller
{
    public function GetClientesHostal(Request $request){
        $query = $request->input('query');
    
        $clientes = ClienteHostal::where('Documento_cliente', 'LIKE', "%$query%")
            ->orWhere('Nombre_cliente', 'LIKE', "%$query%")
            ->orWhere('Apellido_cliente', 'LIKE', "%$query%")
            ->get();
    
        return response()->json($clientes);
    }

    public function RegistrarClienteHostal(Request $request){
        $documentoExiste = ClienteHostal::where('Documento_cliente', $request->Documento_cliente)->exists();

        if ($documentoExiste) {
            return response()->json(['error' => 'El Documento de Cliente ya existe.'], 400);
        }

        try {
            $clientes = ClienteHostal::create([
                'Nombre_cliente' => $request->Nombre_cliente,
                'Apellido_cliente' => $request->Apellido_cliente,
                'NombreCompleto_cliente' => $request->Nombre_cliente . " " . $request->Apellido_cliente,
                'Documento_cliente' => $request->Documento_cliente,
                'Nacionalidad_cliente' => $request->Nacionalidad_cliente,
                'Profesion_cliente' => $request->Profesion_cliente,
                'FechaNacimiento_cliente' => $request->FechaNacimiento_cliente,
                'Edad_cliente' => $request->Edad_cliente,
                'EstadoCivil_cliente' => $request->EstadoCivil_cliente,
                'imagenes' => "null",
            ]);

            return response()->json($clientes);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error al registrar el cliente. ' . $e->getMessage()], 500);
        }
    }

    public function GetClienteHostalSeleccionado($id){
        $cliente = ClienteHostal::where('id', $id)->first();
        return response()->json($cliente);
    }

    public function GetClienteHostalPaginate(Request $request) {
        $query = ClienteHostal::query();
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Nombre_cliente', 'LIKE', "%$search%")
                  ->orWhere('Apellido_cliente', 'LIKE', "%$search%")
                  ->orWhere('Documento_cliente', 'LIKE', "%$search%");
            });
        }
    
        $clientes = $query->orderBy('id', 'desc')->paginate($request->limit ?? 15);
        
        return response()->json($clientes);
    }

    public function GetClienteSalonPaginate(Request $request) {
        $query = ClienteReserva::query();
        
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('NombreCliente', 'LIKE', "%$search%")
                  ->orWhere('CelularCliente', 'LIKE', "%$search%");
            });
        }
    
        $clientes = $query->orderBy('id', 'desc')->paginate($request->limit ?? 15);
        
        return response()->json($clientes);
    }
    
    public function GetClienteSalonSeleccionado($id){
        $cliente = ClienteReserva::where('id', $id)->first();
        return response()->json($cliente);
    }

    public function RegistrarClienteSalon(Request $request){
        $clientes = ClienteReserva::create([
            'NombreCliente' => $request->NombreCompletoSalon,
            'CelularCliente' => $request->CelularSalon,
        ]);

        return response()->json($clientes);
    }
}
