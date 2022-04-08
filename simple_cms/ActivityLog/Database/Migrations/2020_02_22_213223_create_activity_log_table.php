<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('log_name')->nullable()->index();
            $table->text('description');
            $table->unsignedBigInteger('subject_id')->nullable()->index();
            $table->string('subject_type')->nullable()->index();
            $table->unsignedBigInteger('causer_id')->nullable()->index();
            $table->string('causer_type')->nullable()->index();
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
    }
}
