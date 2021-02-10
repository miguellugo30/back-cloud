<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosUsuarios extends Model
{
    use HasFactory;
    /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'telefono_fijo',
        'telefono_movil',
        'extension',
        'user_id'
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'datos_usuarios';
    /*
     * Funcion para obtener solo los registros activos
    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }
    */
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
        return $this->belongsTo('App\Models\Users', 'id', 'user_id');
    }
}
