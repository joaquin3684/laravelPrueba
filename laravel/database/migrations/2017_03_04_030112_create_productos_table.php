<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_proovedor')->unsigned();
            $table->foreign('id_proovedor')->references('id')->on('proovedores');
            $table->string('descripcion');
            $table->double('gastos_administrativos');
            $table->double('ganancia');
            $table->string('nombre');
            $table->string('tipo');
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
        Schema::dropIfExists('productos');
    }
}
