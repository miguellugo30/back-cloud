<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
/**
 * Modelos
 */
use App\Models\LogActividades;
use App\Models\Empresas;


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
        $id = $request->id;
        $url = $request->ruta;

        $directories = Storage::disk('NAS_energeticos')->directories($url);
        $files = Storage::disk('NAS_energeticos')->files($url);


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
        Storage::makeDirectory($request->ruta."/".$request->nombre."/Papelera");
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

        $headers = [
            'Content-Type'  => Storage::disk('NAS_energeticos')->mimeType($request->file),
            'Content-Length'  => Storage::disk('NAS_energeticos')->size($request->file),
        ];

        return Storage::disk('NAS_energeticos')->url($request->file);

    }
    /**
     * Funcion para subir nuevos archivos
     *
     * @param Request $request
     * @return view index
     */
    public function uploadFile(Request $request)
    {
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
        }
    }
    /**
     * Funcion para mostrar el contenido del directior
     * raiz de la empresa
     *
     * @param [int] $id
     * @return view index
     */
    public function viewList(Request $request)
    {
        $id = $request->id;
        $url = $request->ruta;

        $directories = Storage::disk('NAS_energeticos')->directories($url);
        $files = Storage::disk('NAS_energeticos')->files($url);

        $data = collect();

        foreach ($directories as $d)
        {
           $f = collect([
                    'url' => $d,
                    'name' => $this->getName( $d ),
                    'lastModified' => $this->getDate($d),
                    'type' => $this->getType($d),
                    'size' => $this->getSize($d),
           ]);

            $data->push($f);
        }

        foreach ($files as $d)
        {
            $f = collect([
                    'url' => $d,
                    'name' => $this->getName( $d ),
                    'lastModified' => $this->getDate($d),
                    'type' => $this->getType($d),
                    'size' => $this->getSize($d),
                ]);

            $data->push($f);
        }

        return view('drive.index_list', compact('id', 'data', 'url'));
    }
    /**
     * Funcion para obtener el nombre de un archivo
     *
     * @param [string] $file
     * @return [string] $name
     */
    public function getName($file)
    {
        $di = explode('/', $file);
        if ( count($di) > 1 )
        {
            return $di[ count($di) -1  ];
        }
        else
        {
            return $di[0];
        }
    }
    /**
     * Funcion para obtener la fecha de un archivo
     *
     * @param [string] $file
     * @return [date] $date
     */
    public function getDate($file)
    {
        $di = Storage::disk('NAS_energeticos')->lastModified($file);
        $date = Carbon::createFromTimestamp($di)->format('d/m/Y H:i:s');

        return $date;

    }
    /**
     * Funcion para obtener el tipo de un archivo
     *
     * @param [String] $file
     * @return [String] $type
     */
    public function getType($file)
    {
        $ty = explode('/', Storage::disk('NAS_energeticos')->mimeType($file));
        if ( count($ty) > 1 )
        {
            return Str::ucfirst( $ty[ count($ty) -1  ] );
        }
        else
        {
            return Str::ucfirst( $ty[0] );
        }
    }
    /**
     * Funcion para obtener el tamaño  de un archivo
     *
     * @param [string] $file
     * @return [string] $size
     */
    public function getSize($file)
    {
        $size = Storage::disk('NAS_energeticos')->size($file);

        if ($size > 0)
        {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
        }
        else
        {
            return $size;
        }
    }


}
