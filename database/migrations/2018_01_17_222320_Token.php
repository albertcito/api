<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

class Token extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Token', function (Blueprint $table) {
            $table->increments('idToken');
            $table->string('token');
            $table->string('type')->default('validEmail');
            $table->timestamp('usedAt')->nullable()->default(null);
            $table->timestamp('expireAt');

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("Token");
    }
}
