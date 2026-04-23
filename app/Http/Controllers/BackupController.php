<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\BackupDatabaseMail;

class BackupController extends Controller
{
   
    public function crearBackup(Request $request){
        $dbname = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');

        $filename = "backup-" . now()->format('Y-m-d_H-i-s') . ".sql";
        $path = storage_path($filename);

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$dbname} > {$path}";
        $result = null;

        try {
            exec($command, $output, $result);

            if ($result !== 0) {
                throw new \Exception("Error al ejecutar mysqldump.");
            }

            return response()->download($path)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            \Log::error("Error al crear y descargar el backup: " . $e->getMessage());
            return back()->with('error', 'No se pudo generar el backup.');
        }
    }

    public function enviarBackupPorCorreo(Request $request){
         // Obtener datos de conexión desde .env
        $dbname = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        // Nombre y ruta del archivo de backup
        $filename = "backup-" . now()->format('Y-m-d_H-i-s') . ".sql";
        $path = storage_path("app/$filename");

        // Comando mysqldump para exportar la base de datos
        $command = "mysqldump --user=\"{$username}\" --password=\"{$password}\" --host={$host} {$dbname} > {$path}";

        try {
            // Ejecutar el comando y capturar salida y resultado
            exec($command . ' 2>&1', $output, $result);

            if ($result !== 0) {
                Log::error("mysqldump error: ", $output);
                throw new \Exception("Error al ejecutar mysqldump.");
            }

            // Fecha formateada para el correo
            $fecha = now()->format('d/m/Y H:i:s');

            // Enviar correo con el backup adjunto
            Mail::to('aledar16@gmail.com')->send(new BackupDatabaseMail($path, $fecha));

            // Borrar el archivo local para no acumular
            unlink($path);

            return back()->with('success', 'Backup generado y enviado al correo con éxito.');
        } catch (\Exception $e) {
            Log::error("Error al crear o enviar backup: " . $e->getMessage());
            return back()->with('error', 'No se pudo generar ni enviar el backup.');
        }
    }

    public function Pruebas(){
        return view('admin.Pruebas');
    }
}