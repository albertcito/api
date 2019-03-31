<?php

use Illuminate\Database\Seeder;
use App\Model\{
    Activity,
    ActivityClass,
    LangTranslation
};

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $nbWords = 3;
        $variableNbWords = true;
        for ($i=0; $i < 20; $i++) {
            $title = LangTranslation::inRandomOrder()->first();
            $description = LangTranslation::inRandomOrder()
                ->where('idTranslation', '<>', $title->idTranslation)
                ->first();
            $value = Activity::insert([
                'idTitle' => $title->idTranslation,
                'idDescription' => $description->idTranslation,
                'json' => $faker->sentence($nbWords, $variableNbWords),
            ]);
        }
    }
}
