<?php

use Illuminate\Database\Seeder;

class DemandesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Demande::class,5000)->create();
    }
}
