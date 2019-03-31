<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            LangTableSeeder::class,
            TagTableSeeder::class,
            ActivityTableSeeder::class,
            ActivityTagTableSeeder::class,
        ]);
    }
}
