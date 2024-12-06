<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_articulo extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable, HasApiTokens, Notifiable;

    protected $table = 'articulo';
    protected $fillable = [
        'idcategoria',
        'codigo',
        'nombre',
        'precio_venta',
        'stock',
        'descripcion',
        'estado'
    ];
    protected $primaryKey = 'idarticulo';
    public $timestamps = false;

    // Relación con categoria

    public function categoria()
    {
        // id de la tabla modelo, id tabla foranea 
        return $this->belongsTo(In_categoria::class, 'idcategoria', 'idcategoria');
    }

        
    // Para las relaciones donde este modelo es la Primary Key - - puede ser: relación uno a muchos  ⬇️
    public function detalleventa()
    {
        return $this->hasMany(In_detalleventa::class, 'idarticulo', 'idarticulo');
    }

    public function detalleingresos()
    {
        return $this->hasMany(In_detalleingreso::class, 'idarticulo', 'idarticulo');
    }
}
