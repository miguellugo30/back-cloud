<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
/**
 * Modelos
 */
use App\Models\LogActividades;


class DriveEmpresaController extends Controller
{
    /**
     * Funcion para mostrar el contenido del directior
     * raiz de la empresa
     *
     * @param [int] $id
     * @return view index
     */
    public function index(Request $request)
    {
        $data = explode('/',$request->ruta);
        $id = $data[0];
        //Storage::makeDirectory($id);
        //return Storage::download($id.'/11_101.jpeg');
        //$url = Storage::path($request->ruta);
        $url = $request->ruta;
        //$size = Storage::size($id.'/11_101.jpeg');
        //$time = Storage::lastModified($id.'/11_101.jpeg');
        $directories = Storage::directories($request->ruta);
        $files = Storage::files($request->ruta);
        //return $directories;
        return view('drive.index', compact('id', 'directories', 'files', 'url'));
    }
    /**
     * Funcion para crear directorios dentro de la empresa
     *
     * @param [int] $id
     * @return view index
     */
    public function makeDirectorio(Request $request)
    {
        Storage::makeDirectory($request->ruta."/".$request->nombre);
        /**
         * Creamos el log
         */
        LogActividades::create([
            'accion' => 'Crear directorio',
            'archivo' => $request->ruta."/".$request->nombre,
            'user_id' => Auth::id(),
        ]);
    }
    /**
     * Funcion para poder hacer una vista previa de los archivos
     *
     * @param Request $request
     * @return view indes
     */
    public function viewFile(Request $request)
    {
        $file = Storage::url($request->file);
        /**
         * Creamos el log
         */
        LogActividades::create([
            'accion' => 'Visualizar Archivo',
            'archivo' => $request->file,
            'user_id' => Auth::id(),
        ]);
        return view('drive.show', compact('file'));
    }
    /**
     * Funcion para eliminar archivos, moverlos a la papelera
     *
     * @param Request $request
     * @return view index
     */
    public function deleteFile(Request $request)
    {
        $data = explode('/',$request->file);
        if ( Str::contains($request->file, 'Papelera') )
        {
            if ( $request->type == 'directory' )
            {
                Storage::deleteDirectory($request->file);
                /**
                 * Creamos el log
                 */
                LogActividades::create([
                    'accion' => 'Eliminar directorio',
                    'archivo' => $request->file,
                    'user_id' => Auth::id(),
                ]);
            }
            else
            {
                Storage::delete($request->file);
                /**
                 * Creamos el log
                 */
                LogActividades::create([
                    'accion' => 'Eliminar Archivo',
                    'archivo' => $request->file,
                    'user_id' => Auth::id(),
                ]);
            }

        }
        else
        {
            /**
             * Creamos el log
             */
            LogActividades::create([
                'accion' => 'Mover a Papelera',
                'archivo' => $request->file,
                'user_id' => Auth::id(),
            ]);
            Storage::move($request->file, $data[0]."/Papelera/".$data[1] );
        }

        //return redirect()->route('indexDrive', ['empresa_id' => $data[0]]);
    }
    /**
     * Funcion para descar archivos
     *
     * @param Request $request
     * @return void
     */
    public function downloadFile(Request $request)
    {
        /**
         * Creamos el log
         */
        LogActividades::create([
            'accion' => 'Descargar Archivo',
            'archivo' => $request->file,
            'user_id' => Auth::id(),
        ]);
        return response()->download(public_path()."/storage/".$request->file);
    }
    /**
     * Funcion para subir nuevos archivos
     *
     * @param Request $request
     * @return view index
     */
    public function uploadFile(Request $request)
    {
        //dd( $request->file('files') );
        if ( count($request->file()) == 0 )
        {
            return response()->json([
                'message'      =>  'The given data was invalid.',
                'errors'   =>  [
                    'newFiles' => [ 'Debe subir por lo menos un archivo' ]
                    ]
                ], 422);
            }
            else
            {
                for ($i=0; $i < count($request->file('files')); $i++)
                {
                    if ( $request->file('files')[$i]->getSize() < 31000000 && $request->file('files')[$i]->getSize() != false )
                    {
                    //dd( $request->file('files')[$i]->getClientOriginalName() );
                    $request->file('files')[$i]->storeAs(
                        $request->ruta, $request->file('files')[$i]->getClientOriginalName()
                    );
                    /**
                     * Creamos el log
                     */
                    LogActividades::create([
                        'accion' => 'Subir Archivo',
                        'archivo' => $request->ruta.'/'.$request->file('files')[$i]->getClientOriginalName(),
                        'user_id' => Auth::id(),
                    ]);
                }
            }
            //return redirect()->route('indexDrive', ['empresa_id' => $request->ruta]);
        }
    }
}
