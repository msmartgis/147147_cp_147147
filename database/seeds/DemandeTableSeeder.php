<?php

use Illuminate\Database\Seeder;

class DemandeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Demande::class,1000)->create();
    }
}
