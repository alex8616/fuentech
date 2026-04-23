<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Models\HospedajeHabitacion;

trait GenerarCodigoHospedajeTrait
{
    public function generarCodigoHospedajeUnico()
    {
        $codigo = Str::upper(Str::random(8));
        while (HospedajeHabitacion::where('CodigoHospedaje', $codigo)->exists()) {
            $codigo = Str::upper(Str::random(8));
        }
        return $codigo;
    }
}
