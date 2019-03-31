<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Logic\Enum\UserStatus;

class AddDefaultData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('User')->insert([
            'idUser' => 1,
            'name' => 'Miaum Team',
            'email' => 'support@youdomain.com',
            'password' => bcrypt('123456'),
            'status' => UserStatus::_DEFAULT,
            'validEmail' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
