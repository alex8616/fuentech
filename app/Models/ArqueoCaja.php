<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArqueoCaja extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id',
        'user_id',
        'Fecha',
        'Hora',
        'MontoInicial',
        'Segun_SistemaTotalIngreso',
        'Segun_SistemaIngresoEfectivo',
        'Segun_SistemaIngresoTarjeta',
        'Segun_SistemaIngresoDepositoQR',
        'Segun_SistemaTotalEgreso',
        'Segun_SistemaEgresoEfectivo',
        'Segun_SistemaEgresoTarjeta',
        'Segun_SistemaEgresoDepositoQR',
        'Segun_SistemaTotal',
        'Segun_UsuarioEfectivo',
        'Segun_UsuarioTarjeta',
        'Segun_UsuarioDepositoQR',
        'Segun_UsuarioComentario',
        'Segun_UsuarioTotal',
        'Diferencia',
        'Estado',
        'Activo',
        'TotalMovimientoCajaIngresoEfectivo',
        'TotalVentaCajaIngresoEfectivo',
        'TotalMovimientoCajaIngresoTarjeta',
        'TotalVentaCajaIngresoTarjeta',
        'TotalMovimientoCajaIngresoDepositoQR',
        'TotalVentaCajaIngresoDepositoQR',
        'TotalMovimientoCajaEgresoEfectivo',
        'TotalGastoEgresoEfectivo',
        'TotalMovimientoCajaEgresoTarjeta',
        'TotalGastoEgresoTarjeta',
        'TotalMovimientoCajaEgresoDepositoQR',
        'TotalGastoEgresoDepositoQR',
        'TotalCuentaProveedorEgresoEfectivo',
        'TotalCuentaProveedorEgresoTarjeta',
        'TotalCuentaProveedorEgresoDepositoQR',
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
