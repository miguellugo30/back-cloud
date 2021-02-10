<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'razon_social',
        'rfc',
        'calle',
        'numero',
        'colonia',
        'municipio',
        'cp',
        'telefono_1',
        'telefono_2',
        'sitio_web',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'empresas';
    /**
     * Funcion para obtener solo los registros activos
     */
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion uno a uno, con tabla intermedia
     */
    public function Usuarios()
    {
        return $this->belongsToMany('App\Models\Users', 'users_empresas');
    }
}
