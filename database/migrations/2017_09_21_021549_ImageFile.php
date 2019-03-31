<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ImageFile', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('idFile');
            $table->integer('idImage')->unsigned();

            // slug is nullable, because i want put the id_image_file in the name of image
            $table->string('slug')->nullable();
            $table->string('ext', 4)->nullable();
            $table->integer('size')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->boolean('original')->default(0);

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletes();

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
        Schema::dropIfExists('ImageFile');
    }
}