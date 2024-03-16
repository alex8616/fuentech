<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{

    public function GetCliente(){
        $clientes = Cliente::get();
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
    
}
