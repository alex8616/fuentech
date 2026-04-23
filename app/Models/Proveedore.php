<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'documento',
        'empresa_id',
        'email',
        'telefono',
        'direccion',
        'comentario',
        'estado',
        'Total'
    ];

    //Relacion de uno a muchos
    public function empresas(){
        return $this->hasMany(Empresa::class);
    }

    //Relacion de uno a muchos
    public function productos(){
        return $this->hasMany(Producto::class);
    }

    //Relacion de uno a muchos
    public function ingredientes(){
        return $this->hasMany(Ingrediente::class);
    }

    //Relacion de uno a muchos
    public function gastos(){
        return $this->hasMany(Gasto::class);
    }

    public function cuentacorrienteproveedores(){
        return $this->hasMany(CuentaCorrienteProveedor::class);
    }

    // Relación de uno a muchos
    public function detalleStockDates(){
        return $this->hasMany(DetalleStockDate::class, 'proveedor_id');
    }
}
