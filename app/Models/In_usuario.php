<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_usuario extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable, HasApiTokens, Notifiable;

    protected $table = 'usuario';
    protected $fillable = [
        'idrol',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
        'password',
        'estado'
    ];
    protected $primaryKey = 'idusuario';
    public $timestamps = false;

    // Relación con rol

    public function rol()
    {
        // id de la tabla modelo, id tabla foranea 
        return $this->belongsTo(In_rol::class, 'idusuario', 'idrol');
    }
    // Para las relaciones donde este modelo es la Primary Key - - puede ser: relación uno a muchos 
    public function venta()
    {
        // Relación uno a muchos 
        return $this->hasMany(In_venta::class, 'idusuario', 'idusuario');
    }
    
    public function ingresos()
    {
        // Relación uno a muchos 
        return $this->hasMany(In_ingreso::class, 'idusuario', 'idusuario');
    }

}
