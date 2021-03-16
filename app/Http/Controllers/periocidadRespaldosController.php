<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/**
 * Modelos
 */
use App\Models\Empresas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class periocidadRespaldosController extends Controller
{
    private $empresas;
    /*
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesión
     *
    public function __construct(Empresas $empresas)
    {
        $this->empresas = $empresas;
    }
    */
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

    public function num_respaldos($archivos, $num_respaldos)
    {
        if ( count( $archivos ) == $num_respaldos )
        {
            return true;
        }
        return false;
    }

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

    public function dia_semana($fecha, $dia_semana)
    {
        $ds = date('l', strtotime( $fecha) );
        if ( $dia_semana == $ds )
        {
            return true;
        }
        return false;
    }

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

    public function obtener_fecha_nombre($archivo)
    {
        $b = explode( '/', $archivo );
        $f = explode( '_', $b[count( $b ) - 1]);
        $e = explode( '-', $f[1]);
        $dt = Carbon::create( '20'.$e[2], $e[1] , $e[0]);
        return $dt->toDateString();
    }

    public function edit()
    {
        dd( Storage::disk('NAS')->files("GarzaGas") );
    }
}
