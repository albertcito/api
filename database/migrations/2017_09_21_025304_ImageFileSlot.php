<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageFileSlot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ImageFileSlot', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('idImageFileSlot');

            $table->integer('idImage')->unsigned();
            $table->integer('idFile')->unsigned();
            $table->integer('idSlot')->unsigned();

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unique(['idImage', 'idFile', 'idSlot']);
            $table->unique(['idImage', 'idSlot']);

            $table->foreign('idImage')
                    ->references('idImage')->on('Image')
                    ->onDelete('cascade');

            $table->foreign('idFile')
                    ->references('idFile')->on('ImageFile')
                    ->onDelete('cascade');

            $table->foreign('idSlot')
                    ->references('idSlot')->on('DeviceSlot')
                    ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ImageFileSlot');
    }
}