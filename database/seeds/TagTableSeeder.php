<?php

use Illuminate\Database\Seeder;
use App\Model\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $tag = Tag::latest()->first();
        if (!$tag) {
            $tag = new stdClass;
            $tag->idTag = 0;
        }
        for ($i=0; $i < 20; $i++) {
            $id = $tag->idTag + 1;
            $tag = Tag::create([
                'name' => $faker->word . '-'. $id,
            ])->fresh();
        }
    }
}
