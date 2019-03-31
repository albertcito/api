<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Device extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Device', function (Blueprint $table) {
            $deviceType = \App\Logic\Enum\DeviceType::getArray();
            $deviceTypeDefault =  \App\Logic\Enum\DeviceType::_DEFAULT;
            $table->increments('idDevice');
            $table->enum('type', $deviceType)->default($deviceTypeDefault);
            $table->string('name')->unique();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('Devices');
    }
}