<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as F;

class OrganismosTest extends TestCase
{
	use DatabaseMigrations;

    public function testFormularioCompleto()
    {
        $faker = F::create('App\Organismos');
        $this->visit('/organismos')
        ->type($faker->name, 'nombre')
        ->type($faker->swiftBicNumber, 'cuit')
        ->type($faker->numberBetween(0, 100), 'cuota_social')
        ->press('Alta')
        ->assertResponseOk();
    }

    public function testHttpRequest()
    {
        $data = $this->getData();
        $this->post('/organismos', $data)
        ->assertResponseOk()
        ->seeInDatabase('organismos', $data)
        ->seeJson(['created' => true]);

        $data2 = $this->getData();
        $this->put('/organismos/1', $data2)
        ->assertResponseOk()
        ->seeInDatabase('organismos', $data2)
        ->seeJson(['updated' => true]);

     
        $this->get('/organismos/1')
        ->seeJson($data2);

        $this->delete('/organismos/1')
        ->seeJson(['deleted' => true]);
    }


    public function getData($custom = array())
    {
        $faker = F::create('App\Proovedores');
        $data = [            
			'nombre'       => $faker->name,
			'cuit'         => $faker->swiftBicNumber,
			'cuota_social' => $faker->numberBetween(0, 100)            
            ];
        $data = array_merge($data, $custom);
        return $data;
    }
}
