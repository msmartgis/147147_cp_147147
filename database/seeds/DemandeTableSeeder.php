<?php

use Illuminate\Database\Seeder;
use App\Demande;
use Faker\Factory;

class DemandeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        //Demande::truncate();

        foreach (range(1, 500) as $i) {
            $demande = Demande::create([
                'num_ordre' => $faker->num_ordre,
                'date_reception' => $faker->date_reception,
                'objet_fr' => $faker->objet_fr,
                'objet_ar' => $faker->objet_ar,
                'montant_global' => $faker->montant_global,
                'observation' => $faker->observation

            ]);
        }
    }
}
