<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as F;
class ProovedoresTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testExample()
    {
      	$faker = F::create('App\Proovedores');
        $this->visit('/proovedores')
        ->type($faker->name, 'nombre')
        ->type($faker->realText(200, 3), 'descripcion')
        ->type($faker->numberBetween(0, 100), 'porcentaje_retencion')
        ->type($faker->numberBetween(0, 100), 'porcentaje_gastos_administrativos')
        ->press('Submit')
        ->assertResponseOk();

       
    }

}
