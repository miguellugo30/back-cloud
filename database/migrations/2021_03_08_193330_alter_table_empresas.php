<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->unsignedInteger('no_respaldos')->after('activo')->nullable();
            $table->date('dia_mes')->after('no_respaldos')->nullable();
            $table->string('dia_semana', 20)->after('dia_mes')->nullable();
            $table->unsignedInteger('fin_mes')->after('dia_semana')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn(['no_respaldos','dia_mes','dia_semana','fin_mes']);
        });
    }
}
