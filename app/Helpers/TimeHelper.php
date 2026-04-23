<?php

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

if (!function_exists('getBoliviaTime')) {
    function getBoliviaTime()
    {
        $url = 'https://timeapi.io/api/Time/current/zone';
        $params = ['timeZone' => 'America/La_Paz'];

        try {
            $response = Http::timeout(10)->get($url, $params);

            if ($response->successful()) {
                $data = $response->json();
                $datetime = $data['dateTime'] ?? null;

                if ($datetime) {
                    return Carbon::parse($datetime);
                }
            }
        } catch (\Exception $e) {
            // Loguear si lo deseás: Log::error('Error al obtener hora de Bolivia: ' . $e->getMessage());
        }

        // Fallback: devuelve hora del sistema con zona horaria de Bolivia
        return Carbon::now('America/La_Paz');
    }
}

