<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
class ProovedoresTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = F::create('App\Proovedores');
        for ($i=0; $i < 100; $i++)
        {
        	DB::table('proovedores')->insert([
        	'nombre' => $faker->name,
	        'descripcion' => $faker->realText(200, 3),
	        'porcentaje_retencion' => $faker->numberBetween(0, 100),
	        'porcentaje_gastos_administrativos' => $faker->numberBetween(0, 100),
        	]);
        }
    }
}
