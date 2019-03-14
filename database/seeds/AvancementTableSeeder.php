<?php

use Illuminate\Database\Seeder;

class AvancementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Avancement::class,10)->create();
    }
}
