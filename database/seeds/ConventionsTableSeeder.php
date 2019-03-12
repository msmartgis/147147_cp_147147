<?php

use Illuminate\Database\Seeder;

class ConventionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Convention::class,5000)->create();
    }
}
