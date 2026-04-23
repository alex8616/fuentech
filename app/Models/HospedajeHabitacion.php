<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospedajeHabitacion extends Model
{
    use HasFactory;
    protected $fillable = ['ingreso_hospedaje',
                            'hora_ingreso_hospedaje',                        
                            'salida_hospedaje',
                            'procedencia_hospedaje',
                            'destino_hospedaje',
                            'dias_hospedarse',
                            'Precio_habitacion',
                            'PrecioRestante',
                            'Adelanto',
                            'user_id',
                            'habitacion_id',
                            'TotalHospedaje',
                            'TotalServicio',
                            'TotalConsumo',
                            'SubTotal',
                            'Total',
                            'CambioBolivianos',
                            'CambioDolar',
                            'CategoriaHabitacion',
                            'CamaraHotelera',
                            'EstadoHospedaje',
                            'CodigoHospedaje',
                            'EstadoReserva',
                            'EstadoHospedajeGrupo',
                            'Reserva',
                            'GuiaTuristica',
                            'CortesiaHabitacion',
                            'grupo_hospedajes_id',

                            'HospedajeDeuda',
                            'HospedajePendiente',
                            'FechaDeudaConcluida',

                            'HospedajeCancelado'
                        ];
                            
    //Relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion de uno a muchos inversa
    public function habitacion(){
        return $this->belongsTo(Habitacion::class);
    }

    //Relacion de uno a muchos
    public function detallehospedajes(){
        return $this->hasMany(DetalleHospedajeHabitacion::class);
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
    
    public function autos(){
        return $this->hasMany(Auto::class);
    }

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }
    
    public function pagoshospedaje(){
        return $this->hasMany(Pagos::class);
    }

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }

    public function grupohospedaje() {
        return $this->belongsTo(GrupoHospedaje::class, 'grupo_hospedajes_id');  // Especificar la clave foránea correcta
    }
    /*//Relacion de uno a muchos
    public function detalleproductos(){
        return $this->hasMany(DetalleProducto::class);
    }

    //Relacion de uno a muchos
    public function detalleserviciohostals(){
        return $this->hasMany(DetalleServicioHostal::class);
    }

    //Relacion de uno a muchos
    public function hospedajehabitacioninvitados(){
        return $this->hasMany(HospedajeHabitacionInvitado::class);
    }*/
}
