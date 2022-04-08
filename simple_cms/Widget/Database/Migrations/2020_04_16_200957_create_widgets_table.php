<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('widgets') )
        {
            Schema::create('widgets', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('widget_id', 191)->index();
                $table->string('group', 191)->index();
                $table->string('theme', 191)->index();
                $table->tinyInteger('position')->default(1)->index();
                $table->json('settings')->default('[]');

                $table->softDeletes()->index();
                $table->timestamps();
                $table->index('created_at', 'widgets_created_at_index');
                $table->index('updated_at', 'widgets_updated_at_index');
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
        Schema::dropIfExists('widgets');
    }
}
