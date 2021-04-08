<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatNas extends Model
{
    use HasFactory;
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'Nombre',
        'ruta',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'cat_nas';
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
     * Relacion muchos a muchos, con tabla intermedia
     */
    public function Empresas()
    {
        return $this->belongsToMany(Empresas::class, 'empresas_nas');
    }
}
