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
use Goutte\Client;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ConfiguracionController extends Controller
{

    public function scrapeWebPage($url) {
        // Crear una instancia del cliente Guzzle
        $client = new Client();

        try {
            // Realizar la solicitud HTTP GET a la URL
            $response = $client->request('GET', $url);
            
            // Obtener el contenido HTML de la respuesta
            $htmlContent = $response->getBody()->getContents();

            // Crear una instancia del Crawler
            $crawler = new Crawler($htmlContent);

            // Extraer la información que necesitas
            $info = [];

            // Por ejemplo, para extraer todos los enlaces de la página
            $crawler->filter('a')->each(function (Crawler $node, $i) use (&$info) {
                $info[] = $node->attr('href');
            });

            // Puedes añadir más lógica aquí para extraer otros datos según tus necesidades

            // Devolver la información extraída
            return $info;
        } catch (Exception $e) {
            // Manejar cualquier error que ocurra durante la solicitud HTTP
            return "Error: " . $e->getMessage();
        }
    }

    public function scrape(Request $request) {
        // Obtener la URL de la página web desde la solicitud
        $url = $request->input('https://tukos.sdmlabo.com/Asistencia_Biometrico');

        // Verificar si se proporcionó una URL
        if (!$url) {
            return response()->json(['error' => 'Debes proporcionar una URL'], 400);
        }

        // Llamar a la función para scrape
        $result = $this->scrapeWebPage($url);

        // Devolver el resultado como respuesta JSON
        return response()->json($result);
    }

    public function listarImpresoras(){
        $user = Auth::user();
        if ($user) {
            $Impresoras = Configuracion::where('user_id',$user->id)->get();
            return response()->json($Impresoras);
        } else {
            return response()->json("user No INICIADO SESSION");
        }
    }

    public function RegistrarImpresora(Request $request){
        //return response()->json($request);
        
        $registro = Configuracion::where('created_at', '>', Carbon::now()->subSeconds(3))->first();
        if ($registro) {
            return response()->json(['message' => 'Ya has enviado este formulario recientemente. Por favor, espera unos segundos antes de intentarlo de nuevo.'], 429);
        }

        $user = Auth::user();
        if ($user) {
            $Impresora = Configuracion::create([
                'NombreImpresora' => $request->Print,
                'user_id' => $user->id,
                'DireccionIpLocal' => $request->DireccionIp.":8080",
                'Activo' => "false",
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
        $direccionIp = $user->DirecionIpPrincipal;

        $impresora = Configuracion::where('user_id',$user->id)->where('Activo',"true")->first();
        $NombreImpresora = $impresora->NombreImpresora;
        return response()->json([
            'DireccionIp' => $direccionIp,
            'NombreImpresora' => $NombreImpresora,
        ]);
    }

    public function ConfigImpresora(){
        return view('admin.Configuracion.ConfiguracionImpresora');
    }

    public function getLoggedInUser(){
        $user = Auth::user();
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user->DirecionIpPrincipal
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No user logged in.'
            ], 401);
        }
    }

    public function ActualizarImpresora(Request $request){
        $impresora = Configuracion::findOrFail($request->id);
        $impresora->Activo = $request->estado;
        $impresora->DireccionIpLocal = $request->direccion;
        $impresora->save();
        return response()->json(['success' => true]);
    }
    
    public function GetPrintSeleccionado($id){
        $impresora = Configuracion::where('id',$id)->get();
        return response()->json($impresora);
    }

    public function GetHora(){
        
        $hora = getBoliviaTime();
        return response()->json($hora->toDateTimeString());


    }

    
}
