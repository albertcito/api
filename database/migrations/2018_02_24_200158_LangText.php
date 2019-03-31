<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LangText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LangText', function (Blueprint $table) {
            $table->increments('idLangText');
            $table->integer('idLang')->unsigned();
            $table->integer('idTranslation')->unsigned();
            $table->string('text');

            $table->integer('idUserCreate')->nullable();
            $table->integer('idUserUpdate')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->unique(['idTranslation', 'idLang']);

            $table->foreign('idLang')
                    ->references('idLang')
                    ->on('Lang')
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
        Schema::dropIfExists('LangText');
    }
}
