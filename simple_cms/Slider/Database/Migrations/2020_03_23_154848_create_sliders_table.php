<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('sliders') )
        {
            Schema::create('sliders', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('title', 191)->index();
                $table->longText('description')->nullable();
                $table->text('cover')->nullable();
                $table->string('link',250)->nullable();
                $table->string('target_link',20)->default('_self');
                $table->tinyInteger('position')->default(1)->length(2)->index();
                $table->string('status',20)->default('draft')->index();
                $table->softDeletes()->index();
                $table->timestamps();
                $table->index('created_at', 'sliders_created_at_index');
                $table->index('updated_at', 'sliders_updated_at_index');
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
        Schema::dropIfExists('sliders');
    }
}
