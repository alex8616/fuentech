<?php

namespace App\Http\Controllers;

use App\Models\Repartidore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class RepartidoreController extends Controller
{
    public function GetRepartidor(){
        $repartidores = Repartidore::get();
        return response()->json($repartidores);
    }


    public function upload(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480', // 20MB
        ]);
    
        try {
            // Extraer texto de la imagen con Tesseract OCR
            $imagePath = $request->file('image')->store('images', 'public');
            $text = (new TesseractOCR(storage_path('app/public/' . $imagePath)))
                ->lang('spa') // Idioma español
                ->run();
    
            // Seleccionar aleatoriamente entre las dos claves API
            $apiKeys = [env('COHERE_API_KEY_1'), env('COHERE_API_KEY_2')];
            $apiKey = $apiKeys[array_rand($apiKeys)]; // Elegir aleatoriamente
    
            // Enviar el texto a Cohere para procesarlo
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.cohere.ai/v1/generate', [
                'model' => 'command',
                'prompt' => "Extrae los siguientes datos del texto: 
                - Número de documento (CI o Pasaporte)
                - Nombres
                - Apellidos
                - Nacionalidad
                - Profesion o ocupacion
                - Fecha de nacimiento (en formato DD/MM/AAAA).
    
                Devuelve la respuesta en formato JSON con las claves: 
                {
                    'numero_documento': '...',
                    'nombres': '...',
                    'apellidos': '...',
                    'nacionalidad': '...',
                    'profesion': '...',
                    'fecha_nacimiento': '...'
                }
    
                No incluyas otra información ni explicaciones. Aquí está el texto a analizar: $text",
                'max_tokens' => 100,
                'temperature' => 0.7,
            ]);
    
            // Obtener y decodificar la respuesta
            $data = json_decode($response->json()['generations'][0]['text'], true);
    
            return response()->json($data);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error procesando la imagen: ' . $e->getMessage()], 500);
        }
    }
    

private function extractData($text)
{
    // Devuelve todo el texto extraído sin procesar
    return [
        'texto_completo' => $text
    ];
}


}
