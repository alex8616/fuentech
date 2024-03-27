<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'CantidadPersonas',
        'empresa_id',
        'user_id',
        'cliente_id',
        'cliente_temporal_id',
        'camarero_id',
        'ambiente_mesa_id',
        'fecha_venta',
        'subTotal',
        'total',
        'Comentario',
        'ocupado',
        'TipoConsumo',
        'FechaCierre',
        'repartidor_id',
        'EstadoDelivery'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function camarero(){
        return $this->belongsTo(Camarero::class);
    }

    public function repartidor(){
        return $this->belongsTo(Camarero::class);
    }

    public function ambientemesa(){
        return $this->belongsTo(AmbienteMesa::class, 'ambiente_mesa_id');
    }

    public function detalleconsumos(){
        return $this->hasMany(DetalleConsumo::class);
    }

    public function descuentoconsumos(){
        return $this->hasMany(DescuentoConsumo::class);
    }

    public function pagosconsumos(){
        return $this->hasMany(Pagos::class);
    }

    public function clientetemporal(){
        return $this->belongsTo(ClienteTemporal::class, 'cliente_temporal_id');
    }
    
}
