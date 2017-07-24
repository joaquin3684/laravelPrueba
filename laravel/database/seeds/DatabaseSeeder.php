<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OrganismosTablaSeeder::class);
        $this->call(SociosTablaSeeder::class);
        $this->call(ProovedoresTablaSeeder::class);
    }
}
