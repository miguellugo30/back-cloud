<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\ErrorBack;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
/**
 * Modelos
 */
use App\Models\Empresas;
use Illuminate\Support\Facades\Notification;

class periocidadRespaldosController extends Controller
{

    public function index()
    {
        $empresas = Empresas::active()->get();

        foreach ($empresas as $e)
        {

            echo $e->intercompania." ".$e->no_respaldos." ".$e->dia_mes." ".$e->dia_semana." ".$e->fin_mes."<br>";
            $archivos = array_reverse( Storage::files( "Respaldos/".$e->intercompania )  );
            echo "<pre>";
            print_r($archivos);
            echo "</pre>";
            /**
             * Validamos el Número de Respaldos
             */
            if ( !$this->num_respaldos( $archivos, $e->no_respaldos ) )
            {
                $archivo_obligatorios = array();
                /**
                 * Obtenemos los archivos que se tiene que conservar
                 * con base a la configuración que se tiene
                 */
                $n = count($archivos);
                for ($i=0; $i < $n; $i++)
                {
                    $fecha = $this->obtener_fecha_nombre( $archivos[$i] );

                    if ($this->dia_mes($fecha, $e->dia_mes))
                    {
                        array_push($archivo_obligatorios, $archivos[$i]);
                        unset($archivos[$i]);
                    }

                    if ($this->dia_semana($fecha, $e->dia_semana))
                    {
                        array_push($archivo_obligatorios, $archivos[$i]);
                        unset($archivos[$i]);
                    }

                    if ($this->fin_mes($fecha, $e->fin_mes))
                    {
                        array_push($archivo_obligatorios, $archivos[$i]);
                        unset($archivos[$i]);
                    }
                }
                /**
                 * Obtenemos los archivos a conservar
                 * con base a al número de respaldos
                 */
                $datos = array_values($archivos);
                $n = count($datos);

                for ($j=0; $j < $n; $j++)
                {
                    if ( count( $archivo_obligatorios ) != $e->no_respaldos )
                    {
                        if ( !in_array( $datos[$j], $archivo_obligatorios ) )
                        {
                            array_push($archivo_obligatorios, $datos[$j]);

                            unset($datos[$j]);

                        }
                    }
                }
                echo "<pre>";
                print_r($archivo_obligatorios);
                echo "</pre>";
                echo "<pre>";
                print_r($datos);
                echo "</pre>";
                /**
                 * Borramos los archivos que ya no son necesario
                 */
                //Storage::delete($datos);
            }
        }
    }

    public function validate_back_currentDay()
    {
        $empresas = Empresas::active()->get();

        foreach ($empresas as $e)
        {
            echo $e->intercompania." ".$e->razon_social."<br><br>";
            $directorios =  $this->getFilesDirectories( $e->url_respaldo, 1  );
            /**
             * Si no se tiene directorios, se sacan los archivos
             * de la carpeta raíz
             */
            if ( count( $directorios ) == 0 )
            {
                echo "DIRECTORIO ".$e->url_respaldo."<br><br>";

                $archivos = $this->getFilesDirectories( $e->url_respaldo, 2  );
                /**
                 * Obtenemos la fecha del nombre del archivo
                 */
                $f = collect();
                for ($j=0; $j < count($archivos); $j++)
                {
                    $fecha = $this->obtener_fecha_nombre( $archivos[$j] );
                    $f->push($fecha);
                }

                $this->mismo_dia($f);
            }
            else
            {
                for ($i=0; $i < count($directorios); $i++)
                {
                    echo "DIRECTORIO ".$directorios[$i]."<br><br>";

                    $archivos = $this->getFilesDirectories( $directorios[$i], 2  );
                    /**
                     * Obtenemos la fecha del nombre del archivo
                     */
                    $f = collect();
                    for ($j=0; $j < count($archivos); $j++)
                    {
                        $fecha =  $this->obtener_fecha_nombre( $archivos[$j] );
                        $f->push($fecha);
                    }

                    $this->mismo_dia($f);
                }
            }
        }
    }
    /**
     * Función para validar que se tengas en mismo numero
     * de respaldos
     *
     * @param [array] $archivos
     * @param [int] $num_respaldos
     * @return boolean
     */
    public function num_respaldos($archivos, $num_respaldos)
    {
        if ( count( $archivos ) == $num_respaldos )
        {
            return true;
        }
        return false;
    }
    /**
     * Función para validar que sea de la misma fecha
     *
     * @param [collect] $fechas
     * @return boolean
     */
    public function mismo_dia($fechas)
    {
        $currentDay = Carbon::now()->isoFormat('G-MM-DD');
        $currentDay = '2021-03-16';

        if (!$fechas->contains($currentDay))
        {

            Mail::to("ingmchlugo@gmail.com")->send(new ErrorBack('Hola Mundo'));

            echo "NO EXISTE RESPALDO DEL DIA: ".$currentDay. "<br><br>";
        }
    }
    /**
     * Función para validar que sean del mismo dia
     *
     * @param [date] $fecha
     * @param [date] $dia_semana
     * @return boolean
     */
    public function dia_mes($fecha, $dia_semana)
    {
        $conf  = Carbon::create( $dia_semana );
        $diaConf = $conf->isoFormat('DD');
        $f  = Carbon::create( $fecha );
        $diaArchivo = $f->isoFormat('DD');

        if ( $diaConf == $diaArchivo )
        {
            return true;
        }
        return false;

    }
    /**
     * Función para validar que sea del dia de la semana
     *
     * @param [date] $fecha
     * @param [date] $dia_semana
     * @return boolean
     */
    public function dia_semana($fecha, $dia_semana)
    {
        $ds = date('l', strtotime( $fecha) );
        if ( $dia_semana == $ds )
        {
            return true;
        }
        return false;
    }
    /**
     * Función para validar que sea fin de mes
     *
     * @param [date] $fecha
     * @param [date] $fin_mes
     * @return boolean
     */
    public function fin_mes($fecha, $fin_mes)
    {
        $L = new \DateTime( $fecha );
        $ultimo_dia = $L->format( 'Y-m-t' );

        if ( $fin_mes )
        {
            $conf  = Carbon::create( $ultimo_dia );
            $f  = Carbon::create( $fecha );
            if ( $conf->equalTo($f) )
            {
                return true;
            }
            return false;
        }
        return false;
    }
    /**
     * Función para obtener la fecha de un nombre de archivos
     *
     * @param [string] $archivo
     * @return date
     */
    public function obtener_fecha_nombre($archivo)
    {
        $b = explode( '/', $archivo );
        $f = explode( '_', $b[count( $b ) - 1]);
        $e = explode( '-', $f[ count( $f ) - 2 ]);
        $dt = Carbon::create( '20'.$e[2], $e[1] , $e[0]);
        return $dt->toDateString();

    }
    /**
     * Función para descartar directorios con @
     *
     * @param [array] $d
     * @return void
     */
    public function descartar_directorios( $d )
    {
        $n = count($d);
        for ($i=0; $i < $n; $i++)
        {
            if ( Str::contains($d[$i], '@') )
            {
                unset($d[$i]);
            }
        }
        return $d;
    }
    /**
     * Función para obtener directorios y archivos
     *
     * @param [string] $url
     * @param integer $opc
     * @return array
     */
    public function getFilesDirectories($url, $opc = 1)
    {
        if ($opc == 1)
        {
            $d = array_reverse( Storage::disk('NAS_energeticos')->allDirectories( $url )  );
        }
        else
        {
            $d =  array_reverse( Storage::disk('NAS_energeticos')->allFiles( $url )  );
        }

        return $this->descartar_directorios( $d );
    }
}
