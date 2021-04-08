<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConexionesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
/**
 * Modelo
 */
use App\Models\Conexiones;
use App\Models\Empresas;

class ConexionesController extends Controller
{
    private $conexiones;
    private $empresas;
     /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(Empresas $empresas, Conexiones $conexiones)
    {
        $this->conexiones = $conexiones;
        $this->empresas = $empresas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conexiones = $this->conexiones::with('Empresas')->active()->get();

        return view('conexiones.index', compact('conexiones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * Obtenemos las empresas activas
         */
        $empresas = $this->empresas::active()->get();
        return view('conexiones.create', compact('empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConexionesRequest $request)
    {
        if ($request->host_secundario == '')
        {
            $this->conexiones->fill([
                                        'host' => Crypt::encryptString($request->host_principal) ,
                                        'puerto' => Crypt::encryptString($request->puerto_principal),
                                        'usuario' => Crypt::encryptString($request->usuario_principal),
                                        'contrasena' => Crypt::encryptString($request->contrasena_principal),
                                        'ruta' => $request->ruta,
                                        'prioridad' => 1,
                                        'empresas_id' => $request->empresa,
                                    ])->save();
        }
        else
        {
            $this->conexiones->create([
                                        'host' => Crypt::encryptString($request->host_principal) ,
                                        'puerto' => Crypt::encryptString($request->puerto_principal),
                                        'usuario' => Crypt::encryptString($request->usuario_principal),
                                        'contrasena' => Crypt::encryptString($request->contrasena_principal),
                                        'ruta' => $request->ruta,
                                        'prioridad' => 1,
                                        'empresas_id' => $request->empresa,
                                    ]);

            $this->conexiones->create([
                                        'host' => Crypt::encryptString($request->host_secundario) ,
                                        'puerto' => Crypt::encryptString($request->puerto_secundario),
                                        'usuario' => Crypt::encryptString($request->usuario_secundario),
                                        'contrasena' => Crypt::encryptString($request->contrasena_secundario),
                                        'ruta' => $request->ruta,
                                        'prioridad' => 2,
                                        'empresas_id' => $request->empresa,
                                    ]);
        }
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('conexiones.index');
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
        $conexion = $this->conexiones::where('id', $id)->with('Empresas')->first();
        return view('conexiones.edit', compact('conexion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConexionesRequest $request, $id)
    {
         /**
         * Actualizamos el registro
         */
        $this->conexiones::where( 'id', $id )
                        ->update([
                            'host' => Crypt::encryptString($request->host_principal) ,
                            'puerto' => Crypt::encryptString($request->puerto_principal),
                            'usuario' => Crypt::encryptString($request->usuario_principal),
                            'contrasena' => Crypt::encryptString($request->contrasena_principal),
                            'ruta' => $request->ruta,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
         return redirect()->route('conexiones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         /**
         * Desactivamos el registro seleccionado
         */
        $this->conexiones::where( 'id', $id )
                        ->update([
                            'activo' => 0,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('conexiones.index');
    }
}
