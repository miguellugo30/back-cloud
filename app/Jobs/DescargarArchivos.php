<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class DescargarArchivos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $conexion;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $connection = ssh2_connect(\Crypt::decryptString($this->conexion->host), \Crypt::decryptString($this->conexion->puerto));
        ssh2_auth_password($connection, \Crypt::decryptString($this->conexion->usuario), \Crypt::decryptString($this->conexion->contrasena));
        //sleep(30);
        ssh2_scp_recv( $connection, "/root/administradora_condominios.sql", "./administradora_condominios.sql" );
    }
}
