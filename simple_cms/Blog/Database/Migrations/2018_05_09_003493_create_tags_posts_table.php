<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('tags_posts') )
        {
            Schema::create('tags_posts', function (Blueprint $table) {
                $table->bigInteger('tag_id')->unsigned()->index();
                $table->bigInteger('post_id')->unsigned()->index();
                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
                $table->engine = 'InnoDB';
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_posts');
    }
}
