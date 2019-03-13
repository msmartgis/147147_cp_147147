<?php

use Illuminate\Database\Seeder;

class PointDesserviCategorieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PointDesserviCategorie::class,6)->create();
    }
}
