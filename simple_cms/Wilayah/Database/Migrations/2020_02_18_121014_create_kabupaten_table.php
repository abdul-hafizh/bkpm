<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKabupatenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('kabupaten') )
        {
            Schema::create('kabupaten', function (Blueprint $table) {
                $table->string('kode_kabupaten', 15)->primary()->index();
                $table->string('nama_kabupaten', 150)->index();
                $table->tinyInteger('is_kota')->default(0)->index();
                $table->string('kode_negara', 15)->default('360')->index();
                $table->string('kode_provinsi', 15)->index();
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
        Schema::dropIfExists('kabupaten');
    }
}
