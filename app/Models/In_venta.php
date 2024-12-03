<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $fillable = [
        'idcliente',
        'idusuario',
        'tipo_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
    protected $primaryKey = 'idventa';
    public $timestamps = false;

    
    // Relación con persona

    public function persona()
    {
        // id de la tabla modelo, id tabla foranea 
        return $this->belongsTo(In_persona::class, 'idcliente', 'idpersona');
    }
    
    // Relación con usuario

    public function usuario()
    {
        // id de la tabla modelo, id tabla foranea 
        return $this->belongsTo(In_usuario::class, 'idusuario', 'idusuario');
    }
}
