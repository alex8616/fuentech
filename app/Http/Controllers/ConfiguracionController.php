<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printers\Printer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ConfiguracionController extends Controller
{

    public function listarImpresoras(){
        $impresoras = [];
        exec('wmic printer get name', $output);
        foreach ($output as $line) {
            $line = trim($line);
            if (!empty($line) && $line !== 'Name') {
                $impresoras[] = $line;
            }
        }

        return response()->json($impresoras);
    }

    public function RegistrarImpresora(Request $request){
        $user = Auth::user();

        if ($user) {
            $Impresora = Configuracion::create([
                'NombreImpresora' => $request->nombreImpresora,
                'empresa_id' => $user->empresa_id,
            ]);
            return response()->json($Impresora);
        } else {
            return response()->json("user No INICIADO SESSION");
        }

    }

    public function eliminarImpresora($id){
        $impresora = Configuracion::find($id);
        if ($impresora) {
            $impresora->delete();
            return response()->json(['success' => true, 'message' => 'Impresora eliminada correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se encontró la impresora']);
        }
    }

    public function obtenerCountImpresoras(){
        $user = Auth::user();
        $CountImpresora = Configuracion::where('empresa_id',$user->empresa_id)->get();
        return response()->json($CountImpresora);
    }

    public function ImpresionDate($id){
        $impresora = Configuracion::find($id);
        return response()->json($impresora);
    }

    public function generarPDF(){
        $pdf = PDF::loadView('admin.Configuracion.template')->setOptions(['defaultFont' => 'sans-serif'])->setPaper(array(0,0,320,500), 'portrait');
        return $pdf->stream('Date.pdf');
    }

    public function PrintName(){
        $user = Auth::user();
        $impresora = Configuracion::where('empresa_id',$user->empresa_id)->first();
        return response()->json($impresora);
    }

}
