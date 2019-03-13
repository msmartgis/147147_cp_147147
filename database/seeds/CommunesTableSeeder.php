<?php

use Illuminate\Database\Seeder;

class CommunesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Commune::class,20)->create();
    }
}
