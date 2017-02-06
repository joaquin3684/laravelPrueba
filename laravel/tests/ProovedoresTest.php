<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as F;
class ProovedoresTest extends TestCase
{
    
    use DatabaseMigrations;

    public function testFormularioCompleto()
    {
        $faker = F::create('App\Proovedores');
        $this->visit('/proovedores')
        ->type($faker->name, 'nombre')
        ->type($faker->realText(200, 3), 'descripcion')
        ->type($faker->numberBetween(0, 100), 'porcentaje_retencion')
        ->type($faker->numberBetween(0, 100), 'porcentaje_gastos_administrativos')
        ->press('Alta')
        ->assertResponseOk();
    }

    public function testHttpRequest()
    {
        $data = $this->getData();
        $this->post('/proovedores', $data)
        ->assertResponseOk()
        ->seeInDatabase('proovedores', $data)
        ->seeJson(['created' => true]);

        $data2 = $this->getData();
        $this->put('/proovedores/1', $data2)
        ->assertResponseOk()
        ->seeInDatabase('proovedores', $data2)
        ->seeJson(['updated' => true]);

        $this->get('/proovedores/1')
        ->seeJson($data2);

        $this->delete('/proovedores/1')
        ->seeJson(['deleted' => true]);
    }


    public function getData($custom = array())
    {
        $faker = F::create('App\Proovedores');
        $data = [
            'nombre'                            => $faker->name,
            'descripcion'                       => $faker->realText(200, 3),
            'porcentaje_retencion'              => $faker->numberBetween(0, 100),
            'porcentaje_gastos_administrativos' => $faker->numberBetween(0, 100)
            ];
        $data = array_merge($data, $custom);
        return $data;
    }


}
