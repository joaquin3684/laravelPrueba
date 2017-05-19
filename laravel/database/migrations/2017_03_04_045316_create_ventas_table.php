<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
              $table->increments('id');
            $table->timestamps();
            $table->integer('id_asociado')->unsigned();
            $table->integer('id_producto')->unsigned();
            $table->foreign('id_asociado')->references('id')->on('socios');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->integer('alta')->unsigned();
            $table->integer('aprobado')->unsigned();
            $table->foreign('alta')->references('id')->on('users');
            $table->foreign('aprobado')->references('id')->on('users');
            $table->string('descripcion');
            $table->integer('nro_cuotas');
            $table->date('fecha');
            $table->integer('nro_credito');
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
        Schema::dropIfExists('ventas');
    }
}
