<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTranslateableToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_translation', 191)->index()->nullable()->after('slug');
            $table->string('content_translation', 191)->index()->nullable()->after('content');
            $table->string('description_translation', 191)->index()->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('posts', function (Blueprint $table) {

        });*/
    }
}
