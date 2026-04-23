<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Ejecutar el backup diario a las 03:00 AM
        //$schedule->command('backup:enviar-diario')->dailyAt('03:00');
        //$schedule->command('backup:enviar-diario')->everyFiveMinutes();
        $schedule->command('backup:enviar-diario')->twiceDaily(0, 12);
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Registro explícito del comando personalizado (opcional pero recomendado)
     */
    protected $commands = [
        \App\Console\Commands\EnviarBackupDiario::class,
    ];
}
