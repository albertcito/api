<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class UserToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserToken', function (Blueprint $table) {
            $table->increments('idUserToken');
            $table->integer('idUser')->unsigned();
            $table->integer('idToken')->unsigned()->unique();
            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('idUser')
                ->references('idUser')
                ->on('User')
                ->onDelete('cascade');

            $table->foreign('idToken')
                ->references('idToken')
                ->on('Token')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("UserToken");
    }
}
