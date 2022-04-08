<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('shortcode') )
        {
            Schema::create('shortcode', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('name',150)->index();
                $table->string('option',150)->unique()->index();
                $table->text('pattern')->nullable();
                $table->text('replace')->nullable();
                $table->text('content')->nullable();
                $table->text('description')->nullable();
                $table->string('type',25)->default('bbcode')->comment('bbcode, template');
                $table->softDeletes()->index();
                $table->timestamps();
                $table->index('created_at', 'shortcd_created_at_index');
                $table->index('updated_at', 'shortcd_updated_at_index');
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
        Schema::dropIfExists('bbcode');
    }
}
