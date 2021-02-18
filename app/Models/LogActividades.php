<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActividades extends Model
{
    use HasFactory;
     /**
     * Campos que pueden ser modificados
     */
    protected $fillable = [
        'accion',
        'archivo',
        'user_id',
    ];
    /**
     * Nombre de la tabla
     */
    protected $table = 'log_actividades';
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
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
