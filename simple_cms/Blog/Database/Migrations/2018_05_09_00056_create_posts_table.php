<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('posts') )
        {
            Schema::create('posts', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->bigInteger('user_id')->index();
                $table->string('slug',300);
                $table->string('title',300);

                $table->longText('content')->nullable();
                $table->text('description')->nullable();
                $table->text('thumb_image')->nullable();
                $table->boolean('featured')->default(0)->index();
                $table->boolean('comments')->default(0)->index();
                $table->boolean('full_page')->default(0)->index();
                $table->string('type',150)->default('post')->index();
                $table->string('status',50)->default('draft')->index();
                $table->string('format',50)->default('default')->index();
                $table->json('dataJson')->nullable();
                $table->softDeletes()->index();
                $table->timestamps();
                $table->index([\DB::raw('slug(191)')], 'posts_slug_index');
                $table->index([\DB::raw('title(191)')], 'posts_title_index');
                $table->index('created_at', 'posts_created_at_index');
                $table->index('updated_at', 'posts_updated_at_index');
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
        Schema::dropIfExists('posts');
    }
}
