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
        'intercompania',
        'url_respaldo',
        'no_respaldos',
        'ultimo_anio',
        'dia_semana',
        'fin_mes',
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
        return $this->belongsToMany(Users::class, 'users_empresas');
    }
    /**
     * Relacion con Conexiones una a muchos
     */
    public function Conexiones()
    {
        return $this->hasMany(Conexiones::class);
    }
}
