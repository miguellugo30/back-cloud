<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConexiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conexiones', function (Blueprint $table) {
            $table->id();
            $table->string('host', 500);
            $table->string('puerto', 500);
            $table->string('usuario', 500);
            $table->string('contrasena', 500);
            $table->string('ruta', 1000);
            $table->integer('prioridad');
            $table->bigInteger('empresas_id')->unsigned();
            $table->timestamps();
            $table->foreign('empresas_id')->references('id')->on('empresas')->onDelete('cascade')->onUpdate('cascade');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conexiones');
    }
}
