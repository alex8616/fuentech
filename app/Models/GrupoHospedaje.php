<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoHospedaje extends Model
{
    use HasFactory;
    protected $fillable = [
                            'TourName',
                            'CantidadPersonas',
                            'ingreso_hospedaje',
                            'hora_ingreso_hospedaje',                        
                            'salida_hospedaje',
                            'procedencia_hospedaje',
                            'destino_hospedaje',
                            'dias_hospedarse',
                            'Precio_habitacion',
                            'PrecioRestante',
                            'Adelanto',
                            'user_id',
                            'TotalHospedaje',
                            'TotalServicio',
                            'TotalConsumo',
                            'SubTotal',
                            'Total',
                            'CambioBolivianos',
                            'CambioDolar',
                            'CodigoHospedaje',
                            'Estado',
                            'Comentario',
                            'Concluido',
                            'EstadoGrupo'
                        ];

    public function hospedajes() {
        return $this->hasMany(HospedajeHabitacion::class, 'grupo_hospedajes_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function adelantos(){
        return $this->hasMany(Adelanto::class, 'grupo_hospedajes_id');
    }

}
