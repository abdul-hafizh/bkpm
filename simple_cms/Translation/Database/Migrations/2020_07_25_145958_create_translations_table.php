<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('translator.connection'))->create('translator_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 10)->index();
            $table->string('namespace', 191)->default('*')->index();
            $table->string('group', 191)->index();
            $table->string('item', 191)->index();
            $table->longText('text')->nullable();
            $table->boolean('unstable')->default(false)->index();
            $table->boolean('locked')->default(false)->index();
            $table->timestamps();
            $table->foreign('locale')->references('locale')->on('translator_languages');
            $table->unique(['locale', 'namespace', 'group', 'item']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('translator_translations');
    }
}
