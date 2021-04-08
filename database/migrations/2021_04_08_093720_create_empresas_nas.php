<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasNas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_nas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cat_nas_id')->unsigned();
            $table->bigInteger('empresas_id')->unsigned();
            $table->timestamps();
            $table->foreign('cat_nas_id')->references('id')->on('cat_nas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('empresas_nas');
    }
}
