<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('negara') )
        {
            Schema::create('negara', function (Blueprint $table) {
                $table->string('kode_negara', 15)->primary()->index();
                $table->string('nama_negara', 150)->index();

                $table->string('alpha_2', 5)->nullable()->index();
                $table->string('alpha_3', 5)->nullable()->index();

                $table->string('iso_3166_2', 50)->nullable()->index();
                $table->string('region', 100)->nullable()->index();
                $table->string('sub_region', 100)->nullable()->index();
                $table->string('intermediate_region', 100)->nullable()->index();
                $table->string('region_code', 5)->nullable()->index();
                $table->string('sub_region_code', 5)->nullable()->index();
                $table->string('intermediate_region_code', 5)->nullable()->index();

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
        Schema::dropIfExists('negara');
    }
}
