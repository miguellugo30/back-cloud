<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmpresasRequest;
use Illuminate\Support\Facades\Storage;
/**
 * Modelos
 */
use App\Models\Empresas;
use Spatie\Permission\Models\Permission;

class EmpresasController extends Controller
{
    private $empresas;
    private $permisos;
     /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(Empresas $empresas, Permission $permisos)
    {
        $this->empresas = $empresas;
        $this->permisos = $permisos;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /**
         * Obtenemos las empresas activas
         */
        $empresas = $this->empresas::active()->get();
        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(EmpresasRequest $request)
    {
        /**
         * Creamos el nuevo registro
         */
        $empresa = $this->empresas::create([
                                                'razon_social' => $request->razon_social,
                                                'intercompania' => $request->intercompania
                                            ]);
        /**
         * Creamos los permisos para el nueva empresa
         */
        $newPermissions = array( 'view_empresa_', 'delete_empresa_', 'donwload_empresa_' );
        for ($i=0; $i < count( $newPermissions ); $i++)
        {
            $this->permisos::create(['name' => $newPermissions[$i].$empresa->id]);
        }
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('empresas.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        /*
        //Storage::makeDirectory($id);
        //return Storage::download($id.'/11_101.jpeg');
        //$url = Storage::url($id.'/11_101.jpeg');
        //$size = Storage::size($id.'/11_101.jpeg');
        $time = Storage::lastModified($id.'/11_101.jpeg');
        $directories = Storage::directories($id);
        return $directories;
        */
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /**
         * Obtenemos el registro a editar
         */
        $empresa = $this->empresas::where( 'id', $id )->get()->first();

        return view('empresas.edit', compact('empresa'));

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(EmpresasRequest $request, $id)
    {
        /**
         * Actualizamos el registro
         */
        $this->empresas::where( 'id', $id )
                        ->update([
                            'razon_social' => $request->razon_social,
                            'intercompania' => $request->intercompania,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
         return redirect()->route('empresas.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /**
         * Desactivamos el registro seleccionado
         */
        $this->empresas::where( 'id', $id )
                        ->update([
                            'activo' => 0,
                        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('empresas.index');
    }
}
