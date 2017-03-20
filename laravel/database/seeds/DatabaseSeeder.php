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
        $this->call(OrganismosTableSeeder::class);
        $this->call(ProovedoresTableSeeder::class);
        $this->call(SociosTableSeeder::class);
    }
}
