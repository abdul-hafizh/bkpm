<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKecamatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('kecamatan') )
        {
            Schema::create('kecamatan', function (Blueprint $table) {
                $table->string('kode_kecamatan', 15)->primary()->index();
                $table->string('nama_kecamatan', 150)->index();
                $table->string('kode_negara', 15)->default('360')->index();
                $table->string('kode_provinsi', 15)->index();
                $table->string('kode_kabupaten', 15)->index();
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
        Schema::dropIfExists('kecamatan');
    }
}
