<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivityChooseImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ActivityChooseImage', function (Blueprint $table) {
            $table->increments('idActivityChooseImage');
            $table->integer('idActivity')->unsigned();
			$table->integer('idTranslation')->unsigned();
			
			$table->foreign('idActivity')
                    ->references('idActivity')
                    ->on('Activity')
                    ->onDelete('cascade');
			$table->foreign('idTranslation')
					->references('idTranslation')
					->on('LangTranslation')
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
        Schema::dropIfExists('ActivityChooseImage');
    }
}
