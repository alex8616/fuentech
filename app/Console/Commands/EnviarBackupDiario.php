<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BackupDatabaseMail;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class EnviarBackupDiario extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:enviar-diario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un backup de la base de datos y lo envía por correo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbname = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        $filename = "backup-" . now()->format('Y-m-d_H-i-s') . ".sql";
        $path = storage_path($filename);

        $command = [
            'mysqldump',
            "--user={$username}",
            "--password={$password}",
            "--host={$host}",
            $dbname
        ];

        $process = new Process($command);

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error("mysqldump failed: " . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }

            file_put_contents($path, $process->getOutput());

            $fecha = now()->format('d/m/Y H:i:s');

            // Enviar el correo
            Mail::to('aledar16@gmail.com')->send(new BackupDatabaseMail($path, $fecha));

            // Eliminar el archivo local después de enviar (opcional)
            unlink($path);

            $this->info('Backup enviado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en backup diario: " . $e->getMessage());
            $this->error('Fallo al enviar el backup.');
        }
    }
}
