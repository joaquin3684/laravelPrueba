<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Movimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_cuota')->unsigned();

            $table->foreign('id_cuota')->references('id')->on('cuotas');
            $table->double('entrada');
            $table->double('salida');
            $table->date('fecha');
            $table->double('ganancia');
            $table->double('gastos_administrativos');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}
