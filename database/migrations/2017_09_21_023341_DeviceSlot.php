<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeviceSlot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DeviceSlot', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('idSlot');
            $table->integer('idDevice')->unsigned();

            $table->string('name');
            $table->decimal('percent', 3, 2);

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('idDevice')
                ->references('idDevice')->on('Device')
                ->onDelete('cascade');

            $table->unique(['idDevice', 'percent'])
                ->comment('Cannot exist 2 slot with the same percent, because would be the same image');

            $table->unique(['idDevice', 'name'])
                ->comment('Cannot exist 2 slot with the same name in the same Device');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DeviceSlot');
    }
}