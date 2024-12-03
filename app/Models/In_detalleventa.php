<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_detalleventa extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';
    protected $fillable = [
        'idventa',
        'idarticulo',
        'cantidad',
        'precio',
        'descuento'
    ];
    protected $primaryKey = 'iddetalle_venta';
    public $timestamps = false;

    
    // Relación con venta

    public function venta()
    {
        // id de la tabla modelo, id tabla foranea
        return $this->belongsTo(In_venta::class, 'idventa', 'idventa');
    }
    
    // Relación con articulo

    public function articulo()
    {
        // id de la tabla modelo, id tabla foranea
        return $this->belongsTo(In_articulo::class, 'idarticulo', 'idarticulo');
    }
}
