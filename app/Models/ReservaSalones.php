<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaSalones extends Model
{
    use HasFactory;
    protected $fillable = ['ingreso_salon',
                            'hora_ingreso_salon',                        
                            'hora_salida_salon',
                            'hora_ingreso',
                            'hora_salida',
                            'Codigosalon',
                            'Precio_salon',
                            'PrecioRestante',
                            'Adelanto',
                            'Total',
                            'Totalsalon',
                            'TotalServicio',
                            'TotalConsumo',
                            'SubTotal',
                            'Tarifa_salon',
                            'EstadoReserva',
                            'Estado',
                            'ComentarioReserva',
                            'Estadosalon',
                            'cliente_reservas_id',
                            'empresa_reservas_id',
                            'user_id',
                            'salones_id',
                        ];
                            
    //Relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion de uno a muchos inversa
    public function salon(){
        return $this->belongsTo(Salones::class, 'salones_id');
    }

    public function clientereserva(){
        return $this->belongsTo(ClienteReserva::class, 'cliente_reservas_id');
    }

    public function empresareserva(){
        return $this->belongsTo(EmpresaReserva::class, 'empresa_reservas_id');
    }

    //Relacion de uno a muchos
    public function detallereservas(){
        return $this->hasMany(DetalleReservaSalones::class);
    }

    //Relacion de uno a muchos
    public function servicios(){
        return $this->hasMany(Servicio::class);
    }
    
    //Relacion de uno a muchos
    public function servicioconsumos(){
        return $this->hasMany(ServicioConsumo::class);
    }

    public function adelantos(){
        return $this->hasMany(Adelanto::class);
    }
    
    public function pagos(){
        return $this->hasMany(Pagos::class);
    }

}