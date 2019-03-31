<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CIImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ActCIImage', function (Blueprint $table) {
            $table->increments('idCIImage');
            $table->integer('idActivityChooseImage')->unsigned();
			$table->integer('idImage')->unsigned();
			
			$table->foreign('idActivityChooseImage')
                    ->references('idActivityChooseImage')
                    ->on('ActivityChooseImage')
                    ->onDelete('cascade');
			$table->foreign('idImage')
					->references('idImage')
					->on('Image')
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
        Schema::dropIfExists('ActCIImage');
    }
}
