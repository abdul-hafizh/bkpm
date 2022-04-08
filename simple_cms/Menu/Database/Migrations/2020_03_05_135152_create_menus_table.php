<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('menus') )
        {
            Schema::create('menus', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('slug',190)->index()->unique();
                $table->string('name',190)->index();
                $table->longText('option')->nullable();;
                $table->boolean('status')->default(0)->index();
                $table->text('presenter')->nullable()->comment('Class presenter menu');

                $table->softDeletes()->index();
                $table->timestamps();

                $table->index('created_at', 'menus_created_at_index');
                $table->index('updated_at', 'menus_updated_at_index');
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
        Schema::dropIfExists('menus');
    }
}
