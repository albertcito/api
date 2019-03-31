<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ActivityTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = "INSERT INTO ActivityTag(idActivity, idTag)
        SELECT
            Activity.idActivity idActivity,
            Tag.idTag idTag
        FROM
            Activity,
            Tag
        WHERE
            CONCAT(Activity.idActivity, Tag.idTag) NOT IN(
            SELECT
                CONCAT(
                    ActivityTag.idActivity,
                    ActivityTag.idTag
                )
            FROM ActivityTag)";
        DB::insert($sql);
    }
}
