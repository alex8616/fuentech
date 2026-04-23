<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Turno;

trait CambiarEstadoTurnosTrait
{
    public function CambiarEstadoTurnos()
    {
        $currentTime = Carbon::now()->format('H:i:s');
        $turnos = Turno::all();
        
        foreach ($turnos as $turno) {
            $inicio = Carbon::createFromFormat('H:i:s', $turno->Inicio);
            $fin = Carbon::createFromFormat('H:i:s', $turno->Fin);
            $current = Carbon::createFromFormat('H:i:s', $currentTime);
            
            if ($inicio < $fin) {
                $turno->Estado = $current >= $inicio && $current <= $fin ? 'true' : 'false';
            } else {
                $turno->Estado = $current >= $inicio || $current <= $fin ? 'true' : 'false';
            }
            
            $turno->save();
        }

        return $turnos;
    }
}
