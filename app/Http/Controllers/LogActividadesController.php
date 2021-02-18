<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/**
 * Modelsos
 */
use App\Models\User;
use App\Models\LogActividades;

class LogActividadesController extends Controller
{

    private $LogActividades;

     /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(
                                LogActividades $LogActividades
                                )
    {
        $this->middleware(function ($request, $next) {

            //$this->empresa_id = Auth::user()->Empresas->first()->id;

            return $next($request);
        });
        $this->LogActividades = $LogActividades;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = $this->LogActividades::with('Usuarios')->orderBy('created_at', 'desc')->get();
        return view('log.index', compact('log'));
    }
}
