<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingreso';
    protected $fillable = [
        'idproveedor',
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha',
        'impuesto',
        'total',
        'estado'
    ];
    protected $primaryKey = 'idingreso';
    public $timestamps = false;


    // Relación con persona

    public function persona()
    {
        // id de la tabla modelo, id tabla foranea
        return $this->belongsTo(In_persona::class, 'idproveedor', 'idpersona');
    }

    // Relación con usuario

    public function usuario()
    {
        // id de la tabla modelo, id tabla foranea
        return $this->belongsTo(In_usuario::class, 'idusuario', 'idusuario');
    }
    public function detalleingresos()
    {
        // Relación uno a muchos (un ingreso tiene muchos detalles de ingreso)
        return $this->hasMany(In_detalleingreso::class, 'idingreso', 'idingreso');
    }
}
