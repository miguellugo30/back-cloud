<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conexiones extends Model
{
    use HasFactory;
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'host',
        'puerto',
        'usuario',
        'contrasena',
        'ruta',
        'prioridad',
        'empresas_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'conexiones';
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
    public function Empresas()
    {
        return $this->belongsTo(Empresas::class);
    }
}
