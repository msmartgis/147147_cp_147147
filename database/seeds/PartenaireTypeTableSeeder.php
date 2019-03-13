<?php

use Illuminate\Database\Seeder;

class PartenaireTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PartenaireType::class,20)->create();
    }
}
