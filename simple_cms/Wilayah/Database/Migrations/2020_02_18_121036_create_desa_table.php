<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('desa') )
        {
            Schema::create('desa', function (Blueprint $table) {
                $table->string('kode_desa', 15)->primary()->index();
                $table->string('nama_desa', 150)->index();
                $table->tinyInteger('is_kelurahan')->default(0)->index();
                $table->string('kode_negara', 15)->default('360')->index();
                $table->string('kode_provinsi', 15)->index();
                $table->string('kode_kabupaten', 15)->index();
                $table->string('kode_kecamatan', 15)->index();
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
        Schema::dropIfExists('desa');
    }
}
