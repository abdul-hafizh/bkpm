<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('categories_posts') )
        {
            Schema::create('categories_posts', function (Blueprint $table) {
                $table->bigInteger('category_id')->unsigned()->index();
                $table->bigInteger('post_id')->unsigned()->index();
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('categories_posts');
    }
}
