<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('provinsi') )
        {
            Schema::create('provinsi', function (Blueprint $table) {
                $table->string('kode_provinsi', 15)->primary()->index();
                $table->string('nama_provinsi', 150)->index();
                $table->string('hc_key', 20)->nullable()->index();
                $table->string('kode_negara', 15)->default('360')->index();
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
        Schema::dropIfExists('provinsi');
    }
}
