<?php

use Illuminate\Database\Seeder;

class SociosTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = F::create('App\Proovedores');
           for($i=0; $i < 10; $i++){
	        	DB::table('socios')->insert([
	        		'id_organismo' => $faker->numberBetween(0,10),
	        		'nombre' => $faker->name,
	        		]);
        }    }
}
