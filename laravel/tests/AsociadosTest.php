<?php

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as F;

class AsociadosTest extends TestCase
{
   	use DatabaseMigrations;

   	private $data;
    public function setUp()
    {
        parent::setUp();
        $faker = F::create('App\Socios');
        $this->data = [
            'nombre'           => $faker->name,
            'fecha_nacimiento' => $faker->date('Y-m-d'),
            'cuit'             => $faker->swiftBicNumber,
            'dni'              => $faker->randomNumber(8),
            'domicilio'        => $faker->streetAddress,
            'localidad'        => $faker->state,
            'codigo_postal'    => $faker->postcode,
            'telefono'         => $faker->randomNumber(8),
            'legajo'           => $faker->randomNumber(8),
            'fecha_ingreso'    => $faker->date('Y-m-d'),
            'grupo_familiar'   => $faker->randomDigit,
            'id_organismo'     => $faker->randomDigitNotNull
        ];

    }

    public function testFormularioCompleto()
    {
        $faker = F::create('App\Socios');
        $this->visit('/asociados')
        ->type($faker->name, 'nombre')
        ->type($faker->swiftBicNumber, 'cuit')
        ->type($faker->date('Y-m-d'), 'fecha_nacimiento')
        ->type($faker->randomNumber(8), 'dni')
        ->type($faker->streetAddress, 'domicilio')
        ->type($faker->state, 'localidad')
        ->type($faker->postcode, 'codigo_postal')
        ->type($faker->randomNumber(8), 'telefono')
        ->type($faker->randomNumber(8), 'legajo')
        ->type($faker->date('Y-m-d'), 'fecha_ingreso')
        ->type($faker->randomDigit, 'grupo_familiar')
        ->select($faker->randomDigit, 'id_organismo')
        ->press('Alta')
        ->assertResponseOk();
    }

    public function testHttpRequest()
    {

        $data = $this->data;
        $this->post('/asociados', $data)
        ->assertResponseOk()
        ->seeInDatabase('socios', $data)
        ->seeJson(['created' => true]);

        $data2 = $this->data;
        $this->put('/asociados/1', $data2)
        ->assertResponseOk()
        ->seeInDatabase('socios', $data2)
        ->seeJson(['updated' => true]);

     
        $this->get('/asociados/1')
        ->seeJson($data2);

        $this->delete('/asociados/1')
        ->seeJson(['deleted' => true]);
    }


   /* public function getData($custom = array())
    {
        $faker = F::create('App\Socios');
        $data = [
			'nombre'           => $faker->name,
			'fecha_nacimiento' => $faker->date('Y-m-d'),
			'cuit'             => $faker->swiftBicNumber,
			'dni'              => $faker->randomNumber(8),
			'domicilio'        => $faker->streetAddress,
			'localidad'        => $faker->state,
			'codigo_postal'    => $faker->postcode,
			'telefono'         => $faker->randomNumber(8),
			'legajo'           => $faker->randomNumber(8),
			'fecha_ingreso'    => $faker->date('Y-m-d'),
			'grupo_familiar'   => $faker->randomDigit,           
			'id_organismo'     => $faker->randomDigitNotNull
        ];
        $data = array_merge($data, $custom);
        return $data;
    }*/
}
