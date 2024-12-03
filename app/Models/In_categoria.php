<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class In_categoria extends Model 
{
    use HasFactory;

    protected $table = 'categoria';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];
    protected $primaryKey = 'idcategoria';
    public $timestamps = false;
}
