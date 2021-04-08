<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CatNasRequest;

/**
 * Modelos
 */
use App\Models\CatNas;
use App\Models\Empresas;

class CatNasController extends Controller
{
    private $catNas;
    private $empresas;
    /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(Empresas $empresas, CatNas $catNas)
    {
        $this->catNas = $catNas;
        $this->empresas = $empresas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nas = $this->catNas::active()->get();
        return view('nas.index', compact('nas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatNasRequest $request)
    {
        $this->catNas->create([
            'Nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('cat-nas.index');
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
        $nas = $this->catNas::where('id', $id)->first();
        return view('nas.edit', compact('nas'));
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
        $this->catNas::where( 'id', $id )
        ->update([
            'Nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('cat-nas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->catNas::where( 'id', $id )
        ->update([
            'activo' => 0
        ]);
        /**
         * Redirigimos a la ruta index
         */
        return redirect()->route('cat-nas.index');
    }
}
