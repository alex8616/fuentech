<?php

// app/Models/ItemEnvio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemEnvio extends Model
{
    protected $fillable = ['envio_id', 'producto', 'cantidad', 'observaciones'];

    public function envio()
    {
        return $this->belongsTo(Envio::class);
    }
}
