<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE BASE DE DATOS
    |--------------------------------------------------------------------------
    */
    /**
     * Relacion a Empresas
     */
    public function Empresas()
    {
        return $this->belongsToMany('App\Models\Empresas', 'users_empresas');
    }
    /**
     * Relacion a Datos Usuarios
     *
     */
    public function DatosUsuarios()
    {
        return $this->hasOne('App\Models\DatosUsuarios', 'user_id', 'id');
    }
    /**
     * Relacion a Log Actividades
     *
     */
    public function LogActividades()
    {
        return $this->hasMany('App\Models\LogActividades', 'user_id', 'id');
    }
}
