<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ActivityTag', function (Blueprint $table) {
            $table->increments('idActivityTag');
            $table->integer('idActivity')->unsigned();
            $table->integer('idTag')->unsigned();

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unique([ 'idActivity','idTag']);

            $table->foreign('idActivity')
                    ->references('idActivity')
                    ->on('Activity')
                    ->onDelete('cascade');
            $table->foreign('idTag')
                    ->references('idTag')
                    ->on('Tag')
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
        Schema::dropIfExists('ActivityTag');
    }
}
