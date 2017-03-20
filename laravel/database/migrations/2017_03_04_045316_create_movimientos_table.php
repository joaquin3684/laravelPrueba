<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
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
            $table->integer('id_asociado')->unsigned();
            $table->integer('id_producto')->unsigned();
            $table->foreign('id_asociado')->references('id')->on('socios');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->string('descripcion');
            $table->integer('nro_cuotas');
            $table->date('fecha');
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
