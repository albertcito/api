<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Logic\Enum\ActivityType;

class Activity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Activity', function (Blueprint $table) {
            $type = ActivityType::getArray();
            $table->increments('idActivity');
            $table->enum('type', $type)->default(ActivityType::_DEFAULT);
            $table->integer('idTitle')->unsigned();
            $table->integer('idDescription')->nullable()->unsigned();
            $table->longText('json');

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('idTitle')
                    ->references('idTranslation')
                    ->on('LangTranslation')
                    ->onDelete('cascade');
            $table->foreign('idDescription')
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
        Schema::dropIfExists('Activity');
    }
}
