<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('jobs') ) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts')->index();
                $table->unsignedInteger('reserved_at')->nullable()->index();
                $table->unsignedInteger('available_at')->index();
                $table->unsignedInteger('created_at')->index();
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
        Schema::dropIfExists('jobs');
    }
}
