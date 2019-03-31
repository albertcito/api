<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Lang', function (Blueprint $table) {
            $table->increments('idLang');
            $table->string('code')->unique();
            $table->string('name');

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        DB::table('Lang')->insert([
            ['code' => 'EN', 'name' => 'English'],
            ['code' => 'ES', 'name' => 'Spanish'],
            ['code' => 'FR', 'name' => 'French'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Lang');
    }
}
