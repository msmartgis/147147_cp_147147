<?php

use Illuminate\Database\Seeder;

class PorteurProjetTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Porteur::class,20)->create();
    }
}
