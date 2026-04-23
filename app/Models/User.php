<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'pin', 
        'name', 
        'email', 
        'password', 
        'empresa_id', 
        'DirecionIpPrincipal',
        'estado'
    ];

    public function setPinAttribute($value)
    {
        $this->attributes['pin'] = Hash::make($value);
    }   
    
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    //Relacion de uno a muchos inversa
    public function empresas(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    //Relacion de uno a muchos inversa
    public function consumos(){
        return $this->belongsTo(Consumo::class, 'empresa_id');
    }

    // Relación de uno a muchos
    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }

    // Relación de uno a muchos
    public function gastos(){
        return $this->hasMany(Gasto::class);
    }

    public function configuracions(){
        return $this->hasMany(Configuracion::class);
    }

    public function arqueocajas(){
        return $this->hasMany(ArqueoCaja::class);
    }

    //Relacion de uno a muchos
    public function detallecajas(){
        return $this->hasMany(DetalleCaja::class);
    }

    public function problemakardex(){
        return $this->hasMany(ProblemaKardex::class, 'user_id');
    }
}
