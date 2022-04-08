<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up()
	{
	    /*
		if ( ! Schema::hasTable('table_name') ) {
            Schema::create('table_name', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();

                $table->timestamps();
                $table->softDeletes()->index();
                $table->index('created_at', 'table_name_created_at_index');
                $table->index('updated_at', 'table_name_updated_at_index');
                $table->engine = 'InnoDB';
            });
        }
        */
	}

	/**
	 * Reverse the migration.
	 */
	public function down()
	{
        // Schema::dropIfExists('table_name');
	}
}
