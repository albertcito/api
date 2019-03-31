<?php

use Illuminate\Database\Seeder;
use App\Model\{
    Lang,
    LangTranslation,
    LangText
};

class LangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();


        $langs = Lang::all();
        $translation = LangTranslation::latest()->first();
        if (!$translation) {
            $translation = new stdClass;
            $translation->idTranslation = 0;
        }
        for ($i=0; $i < 20; $i++) {
            $id = $translation->idTranslation + 1;
            $translation = LangTranslation::create([
                'code' => $faker->word . '-'. $id,
            ])->fresh();
            foreach ($langs as $lang) {
                $text = $faker->word . ' ('. $lang->code .')';
                LangText::create([
                    'text' => $text,
                    'idLang' => $lang->idLang,
                    'idTranslation' => $translation->idTranslation
                ])->fresh();
            }
        }
    }
}
