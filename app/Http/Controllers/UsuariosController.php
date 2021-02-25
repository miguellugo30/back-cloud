<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UsuariosRequest;
use Illuminate\Support\Facades\Artisan;
/**
 * Modelos
 */
use App\Models\User;
use App\Models\Empresas;
use App\Models\DatosUsuarios;

class UsuariosController extends Controller
{
    private $user;
    private $roles;
    private $empresas;
     /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
                                User $user,
                                Role $roles,
                                Empresas $empresas
                                )
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });

        $this->user = $user;
        $this->roles = $roles;
        $this->empresas = $empresas;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = $this->user::role(['Usuario', 'Administrador'])->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * Obtenemos todos los roles del sistema
         */
        $roles = $this->roles::where('name', '<>', 'Super Admin')->get();
        /**
         * Recuperamos las empresas activas
         */
        $empresas = $this->empresas::active()->get();

        return view('usuarios.create', compact('roles', 'empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuariosRequest $request)
    {
        /**
         * Obtenemos todos los datos del formulario de alta
         */
        $input = $request->all();
        /**
         * Encriptamos la contrasenia
         */
        $input['password'] = Hash::make($input['password']);
        /**
         * Insertamos la informacion del formulario
         */
        $user = $this->user::create($input);
        /**
         * Asignamos el rol elegido
         */
        $user->assignRole( $request->input('rol') );
        /**
         * Asignamos las categorias al usuario
         */
        $user->syncPermissions( $request->input('arr'));
        /**
         * Limpiamos la cache
         */
        Artisan::call('cache:clear');
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('usuarios.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /**
         * Obtenemos todos los roles del sistema
         */
        $roles = $this->roles::where('name', '<>', 'Super Admin')->get();
        /**
         * Obtenemos el usuario a editar
         */
        $usuario = $this->user::where('id',$id)->first();
        /**
         * Recuperamos las empresas activas
         */
        $empresas = $this->empresas::active()->get();

        return view('usuarios.edit', compact('roles', 'empresas', 'usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
         * Si el pass, viene vacio no lo actualizamos
         */
        if ($request->password != NULL )
        {
           $user = $this->user::where( 'id', $id )
                                ->update([
                                    'name' => $request->name,
                                    'email'   => $request->email,
                                    'password' => Hash::make( $request->password )
                                ]);
       }
       else
       {
           $user = $this->user::where( 'id', $id )
                                ->update([
                                    'name' => $request->name,
                                    'email'   => $request->email
                                ]);
       }
       /**
        * Actualizamos los datos del usuario
        */
       /**
        * Se valida si el usuario ya cuenta con ese rol,
        * Si no se renueve el rol y se le asigna el nuevo
        */
       $user = $this->user::find( $id );
       $user->syncRoles([ $request->rol ]);
       /**
        * Eliminamos los menus que tiene el usuario
        * y le asignamos las nuevas seleccionada
        */
       $user->syncPermissions( $request->input('arr'));
       /**
        * Limpiamos la cache
        */
       Artisan::call('cache:clear');
       /**
        * Redirigimos a la ruta index
        */
       return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user::find( $id );
        $user->syncRoles();
        $user->syncPermissions();
        $user->delete();
        /**
        * Limpiamos la cache
        */
       Artisan::call('cache:clear');
       /**
        * Redirigimos a la ruta index
        */
       return redirect()->route('usuarios.index');
    }
}
