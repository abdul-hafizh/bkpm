<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('tags') )
        {
            Schema::create('tags', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('slug',191)->index()->unique();
                $table->string('name',191)->index();
                $table->string('type',50)->default('post')->index();
                $table->softDeletes()->index();
                $table->timestamps();
                $table->index('created_at', 'tag_created_at_index');
                $table->index('updated_at', 'tag_updated_at_index');
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
        Schema::dropIfExists('tags');
    }
}
