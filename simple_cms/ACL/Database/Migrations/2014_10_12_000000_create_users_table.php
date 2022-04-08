<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('users') ) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->bigInteger('group_id')->unsigned()->index();
                $table->bigInteger('role_id')->unsigned()->index();
                $table->string('name',150)->index();
                $table->string('username',150)->index()->unique();
                $table->string('email',70)->index()->unique();
                $table->string('password',180)->index()->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->boolean('status')->default(0)->index();
                $table->string('path',150)->nullable()->index();
                $table->text('avatar')->nullable();
                $table->string('mobile_phone',20)->nullable();
                $table->string('address',250)->nullable();
                $table->string('postal_code',10)->nullable();
                $table->timestamps();
                $table->softDeletes()->index();

                $table->index('created_at', 'users_created_at_index');
                $table->index('updated_at', 'users_updated_at_index');
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
        Schema::dropIfExists('users');
    }
}
