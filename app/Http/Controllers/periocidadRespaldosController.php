<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\ErrorBack;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
/**
 * Modelos
 */
use App\Models\Empresas;
use App\Models\User;
use phpDocumentor\Reflection\Types\This;

class periocidadRespaldosController extends Controller
{

    public function index()
    {
        $empresas = Empresas::active()->get();

        foreach ($empresas as $e)
        {
            echo $e->razon_social." ".$e->no_respaldos." ".$e->no_respaldos." ".$e->dia_semana." ".$e->fin_mes." ".$e->ultimo_anio."<br>";

            $directorios =  $this->getFilesDirectories( $e->url_respaldo, 1  );
            echo "<pre>";
            print_r($directorios);
            echo "<pre>";
            /**
             * Si no se tiene directorios, se sacan los archivos
             * de la carpeta raíz
             */
            if ( count( $directorios ) == 0 )
            {
                $archivos = $this->getFilesDirectories( $e->url_respaldo, 2  );
                $this->validarDirectorios($e->url_respaldo);
                $this->validar_archivos($archivos, $e, $e->url_respaldo);
            }
            else
            {
                for ($i=0; $i < count($directorios); $i++)
                {
                    echo $directorios[$i]."<br>";

                    $this->validarDirectorios($directorios[$i]);
                    $archivos = $this->getFilesDirectories( $directorios[$i], 2  );
                    $this->validar_archivos($archivos, $e, $directorios[$i]);
                }
            }
        }
    }
    /**
     * Función para validar que archivos se mueven a que ruta
     * y cuales se deberan borrar
     *
     * @param [array] $archivos
     * @param [array] $e
     * @param [string] $ruta
     * @return void
     */
    private function validar_archivos($archivos, $e, $ruta)
    {
        echo "<pre> INICIALES";
            print_r($archivos);
            echo "<pre>";
        /**
         * Obtenemos los archivos que se tiene que conservar
         * con base a la configuración que se tiene
         **/
        $ultimo_anio = array();
        $fin_mes = array();
        $dia_semana = array();
        $n = count($archivos);
        for ($i=0; $i < $n; $i++)
        {

            list($nombre, $fecha) = $this->obtener_fecha_nombre( $archivos[$i] );

            if ($this->ultimo_anio($fecha, $e->ultimo_anio))
            {
                //Storage::disk('NAS_energeticos')->move( $archivos[$i],  $ruta."\Anual\/".$nombre);
                array_push($ultimo_anio, $archivos[$i] );
                unset($archivos[$i]);
            }

            if ($this->fin_mes($fecha, $e->fin_mes))
            {
                //Storage::disk('NAS_energeticos')->move( $archivos[$i],  $ruta."\Mensual\/".$nombre);
                array_push($fin_mes, $archivos[$i] );
                unset($archivos[$i]);
            }

            if ($this->dia_semana($fecha, $e->dia_semana))
            {
                $ordernados =$this->ordenarArchivos(  Storage::disk('NAS_energeticos')->allFiles( $ruta."\Semanal" ) );

                if (  count( $ordernados ) != 5 )
                {
                    //Storage::disk('NAS_energeticos')->move( $archivos[$i],  $ruta.'\Semanal\/'.$nombre);
                    array_push($dia_semana, $archivos[$i] );
                    unset($archivos[$i]);
                }
                else
                {
                    //Storage::disk('NAS_energeticos')->delete($ordernados[0]);
                    //Storage::disk('NAS_energeticos')->move( $archivos[$i],  $ruta.'\Semanal\/'.$nombre);
                    array_push($dia_semana, $archivos[$i] );
                    unset($archivos[$i]);
                }
            }

        }

        echo "<pre> FIN ANIO";
        print_r($ultimo_anio);
        echo "<pre>";
        echo "<pre> ULTIMO MES";
        print_r($fin_mes);
        echo "<pre>";
        echo "<pre> DIA SEMANA";
        print_r($dia_semana);
        echo "<pre>";
        /**
         * Obtenemos los archivos a conservar
         * con base a al número de respaldos
         **/
        $archivos = array_values( $archivos );
        $n = count( $archivos);
        $diarios = array();
        for ($j=0; $j < $n; $j++)
        {
            $ordernados =$this->ordenarArchivos(  Storage::disk('NAS_energeticos')->allFiles( $ruta."\Diarios" ) );

            if (  count( $ordernados ) != $e->no_respaldos )
            {
                list($nombre, $fecha) = $this->obtener_fecha_nombre( $archivos[$j] );
                //Storage::disk('NAS_energeticos')->move( $archivos[$j],  $ruta.'\Diarios\/'.$nombre);
                array_push($diarios, $archivos[$j]);
                unset($archivos[$j]);

            }
            else
            {
                if ( count( $archivos ) > 0 )
                {
                    //Storage::disk('NAS_energeticos')->delete($ordernados[0]);

                    $n = count($archivos);
                    for ($i=0; $i < $n; $i++)
                    {
                        list($nombre, $fecha) = $this->obtener_fecha_nombre( $archivos[$i] );
                        //Storage::disk('NAS_energeticos')->move( $archivos[$i],  $ruta.'\Diarios\/'.$nombre);
                        array_push($diarios, $archivos[$i]);
                        unset($archivos[$i]);
                    }
                }

            }
        }
        echo "<pre> DIARIOS";
        print_r($diarios);
        echo "<pre>";
        echo "<pre> ELIMINAR";
        print_r($archivos);
        echo "<pre>";
        /**
         * Borramos los archivos que ya no son necesario
         **/
        //Storage::disk('NAS_energeticos')->delete($archivos);
    }

    public function validate_back_currentDay()
    {
        $empresas = Empresas::active()->get();

        foreach ($empresas as $e)
        {
            $directorios =  $this->getFilesDirectories( $e->url_respaldo, 1  );
            /**
             * Si no se tiene directorios, se sacan los archivos
             * de la carpeta raíz
             */
            if ( count( $directorios ) == 0 )
            {
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

                $this->mismo_dia($f, $e->razon_social, $e->url_respaldo);
            }
            else
            {
                for ($i=0; $i < count($directorios); $i++)
                {
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

                    $this->mismo_dia($f, $e->razon_social, $directorios[$i]);
                }
            }
        }
    }
    /**
     * Función para validar que sea de la misma fecha
     *
     * @param [collect] $fechas
     * @return boolean
     */
    private function mismo_dia($fechas, $empresa, $ruta)
    {
        $currentDay = Carbon::now()->isoFormat('G-MM-DD');

        if (!$fechas->contains($currentDay))
        {
            /**
             * Obtenemos los usuarios administradores
             */
            $usuarios = User::role(['Administrador'])->select('email')->get();

            foreach ($usuarios as $u)
            {
                Mail::to($u->email)->send(new ErrorBack($empresa, $ruta, $currentDay));
            }
        }
    }
    /**
     * Función para validar que sean del mismo dia
     *
     * @param [date] $fecha
     * @param [date] $dia_semana
     * @return boolean
     */
    private function ultimo_anio($fecha, $ultimo_anio)
    {
        //$conf  = Carbon::create( $ultimo_anio );
        //$diaConf = $conf->isoFormat('DD');
        $f  = Carbon::create( $fecha );

        $date = date('Y-12-d');

        $L = new \DateTime( $date );
        $ultimo_dia_anio = $L->format( 'Y-m-t' );
        $uda  = Carbon::create( $ultimo_dia_anio );

        if ( $ultimo_anio )
        {
            if ( $uda->equalTo($f) )
            {
                return true;
            }
            return false;
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
    private function dia_semana($fecha, $dia_semana)
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
    private function fin_mes($fecha, $fin_mes)
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
    private function obtener_fecha_nombre($archivo)
    {
        $b = explode( '/', $archivo );
          $f = explode( '_', $b[count( $b ) - 1]);
        $e = explode( '-', $f[ count( $f ) - 2 ]);
        $dt = Carbon::create( '20'.$e[2], $e[1] , $e[0]);

        return array( $b[count( $b ) - 1], $dt->toDateString() );

    }
    /**
     * Función para descartar directorios con @
     *
     * @param [array] $d
     * @return void
     */
    private function descartar_directorios( $d )
    {
        $n = count($d);
        for ($i=0; $i < $n; $i++)
        {
            if ( Str::contains($d[$i], ['@', 'Diarios', 'Semanal', 'Mensual', 'Anual']) )
            {
                unset($d[$i]);
            }
        }
        return array_values($d);
    }
    /**
     * Función para obtener directorios y archivos
     *
     * @param [string] $url
     * @param integer $opc
     * @return array
     */
    private function getFilesDirectories($url, $opc = 1)
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
    /**
     * Función para order los archivos por fecha
     *
     * @param [array] $archivos
     * @return array
     */
    public function ordenarArchivos($archivos)
    {
        $n = array();

        for ($i=0; $i < count($archivos); $i++)
        {
            list($nombre, $fecha) = $this->obtener_fecha_nombre( $archivos[$i] );

            $p = array( $fecha, $nombre, $archivos[$i] );
            array_push( $n, $p );
        }

        usort($n, function ($a, $b) {
            return strcmp($a[0], $b[0]);
        });

        return $n;

    }
    /**
     * Funcion para validar que existan los directorios
     * Diarios
     * Semanal
     * Mensual
     * Anual
     *
     * @param [string] $ruta
     * @return void
     */
    public function validarDirectorios($ruta)
    {
        if( !Storage::disk('NAS_energeticos')->exists($ruta.'\Diarios')  )
        {
            Storage::disk('NAS_energeticos')->makeDirectory($ruta.'\Diarios');
        }

        if( !Storage::disk('NAS_energeticos')->exists($ruta.'\Semanal')  )
        {
            Storage::disk('NAS_energeticos')->makeDirectory($ruta.'\Semanal');
        }

        if( !Storage::disk('NAS_energeticos')->exists($ruta.'\Mensual')  )
        {
            Storage::disk('NAS_energeticos')->makeDirectory($ruta.'\Mensual');
        }

        if( !Storage::disk('NAS_energeticos')->exists($ruta.'\Anual')  )
        {
            Storage::disk('NAS_energeticos')->makeDirectory($ruta.'\Anual');
        }
    }
}
