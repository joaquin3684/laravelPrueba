<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_movimiento')->unsigned();
            $table->foreign('id_movimiento')->references('id')->on('movimientos');
            $table->integer('importe');
            $table->boolean('pago')->default(0);
            $table->date('fecha_pago');
            $table->integer('nro_cuota');
            $table->boolean('cobro')->default(0);
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
        Schema::dropIfExists('cuotas');
    }
}
