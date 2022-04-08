<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('contact_messages') )
        {
            Schema::create('contact_messages', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('name')->nullable()->index();
                $table->string('email')->nullable()->index();
                $table->string('phone')->nullable()->index();
                $table->string('website')->nullable()->index();
                $table->text('subject')->nullable();
                $table->longText('message')->nullable();
                $table->json('user_info')->default('[]');

                $table->softDeletes()->index();
                $table->timestamps();
                $table->index('created_at', 'cm_created_at_index');
                $table->index('updated_at', 'cm_updated_at_index');
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
        Schema::dropIfExists('contact_messages');
    }
}
