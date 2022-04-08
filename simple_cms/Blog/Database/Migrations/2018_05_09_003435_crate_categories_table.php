<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('categories') )
        {
            Schema::create('categories', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->bigInteger('parent_id')->nullable()->index();
                $table->string('slug',191)->index()->unique();
                $table->string('name',191)->index();
                $table->string('description',250)->nullable();
                $table->string('type',50)->default('post')->index();
                $table->text('thumb_image')->nullable();
                $table->softDeletes()->index();
                $table->timestamps();
                $table->index('created_at', 'ctg_created_at_index');
                $table->index('updated_at', 'ctg_updated_at_index');
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
        Schema::dropIfExists('categories');
    }
}
