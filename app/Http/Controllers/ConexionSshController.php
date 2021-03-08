<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Jobs\DescargarArchivos;
/**
 * Modelo
 */
use App\Models\Conexiones;

class ConexionSshController extends Controller
{
    private $conexiones;
     /**
     * Constructor para obtener el id empresa
     * con base al usuario que esta usando la sesion
     */
    public function __construct(Conexiones $conexiones)
    {
        $this->conexiones = $conexiones;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function my_ssh_disconnect($reason, $message, $language) {
        printf("Servidor desconectado con el siguiente código [%d] y mensaje: %s\n",
               $reason, $message);
      }

    public function index()
    {
        $conexion = $this->conexiones::find(1);

        $methods = array(
                        'kex' => 'diffie-hellman-group1-sha1',
                        'client_to_server' => array(
                            'crypt' => '3des-cbc',
                            'comp' => 'none'),
                        'server_to_client' => array(
                            'crypt' => 'aes256-cbc,aes192-cbc,aes128-cbc',
                            'comp' => 'none')
                        );
          
        $callbacks = array('disconnect' => 'my_ssh_disconnect');

        //dd($conexion);

        $connection = \ssh2_connect(
                                        \Crypt::decryptString($conexion->host), 
                                        \Crypt::decryptString($conexion->puerto),
                                        $methods
                                    );

        if (!$connection)
        {
            die('Conexión fallida');
        }
        else
        {
            echo "conexion exitosa ssh";

            if (ssh2_auth_password($connection, \Crypt::decryptString($conexion->usuario), \Crypt::decryptString($conexion->contrasena))) 
            {
                /*
                echo "<br>Authentication Successful!<br>";

                $sftp = ssh2_sftp($connection);

                $dir = "ssh2.sftp://$sftp/root/";
                
                $handle = opendir($dir);
                
                $tempArray = array();
                
                while (false !== ($file = readdir($handle))) {
                    if (substr("$file", 0, 1) != "."){
                      if(is_dir($file)){
                //                $tempArray[$file] = $this->scanFilesystem("$dir/$file");
                       } else {
                         $tempArray[]=$file;
                       }
                     }
                    }
                   closedir($handle);
                
                echo "<pre>";
                print_r( $tempArray );
                echo "</pre>";
                */
                DescargarArchivos::dispatch($conexion)->delay(now()->addMinutes(10));
                //ssh2_scp_recv( $connection, "/root/administradora_condominios.sql", "./administradora_condominios.sql" );

            } 
            else
            {
                die('Authentication Failed...');
              }

        }

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
