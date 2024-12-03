<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_detalleingreso extends Model
{
    use HasFactory;

    protected $table = 'detalle_ingreso';
    protected $fillable = [
        'idingreso',
        'idarticulo',
        'cantidad',
        'precio'
    ];
    protected $primaryKey = 'iddetalle_ingreso';
    public $timestamps = false;

    
    // Relación con ingreso

    public function ingreso()
    {
        // id de la tabla modelo, id tabla foranea
        return $this->belongsTo(In_ingreso::class, 'idingreso', 'idingreso');
    }
    
    // Relación con articulo

    public function articulo()
    {
        // id de la tabla modelo, id tabla foranea
        return $this->belongsTo(In_articulo::class, 'idarticulo', 'idarticulo');
    }
}
