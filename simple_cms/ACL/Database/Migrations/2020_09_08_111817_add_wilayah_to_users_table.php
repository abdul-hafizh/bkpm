<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWilayahToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // example; change this.
                if (!Schema::hasColumn('users', 'id_negara')) {
                    $table->string('id_negara', 15)->nullable()->index()->after('postal_code');
                    /*$table->foreign('id_negara')
                    ->references('kode_negara')->on('negara')
                    ->nullOnDelete();*/
                }
                if (!Schema::hasColumn('users', 'id_provinsi')) {
                    $table->string('id_provinsi', 15)->nullable()->index()->after('id_negara');
                    /*$table->foreign('id_provinsi')
                    ->references('kode_provinsi')->on('provinsi')
                    ->nullOnDelete();*/
                }
                if (!Schema::hasColumn('users', 'id_kabupaten')) {
                    $table->string('id_kabupaten', 15)->nullable()->index()->after('id_provinsi');
                    /*$table->foreign('id_kabupaten')
                    ->references('kode_kabupaten')->on('kabupaten')
                    ->nullOnDelete();*/
                }
                if (!Schema::hasColumn('users', 'id_kecamatan')) {
                    $table->string('id_kecamatan', 15)->nullable()->index()->after('id_kabupaten');
                    /*$table->foreign('id_kecamatan')
                    ->references('kode_kecamatan')->on('kecamatan')
                    ->nullOnDelete();*/
                }
                if (!Schema::hasColumn('users', 'id_desa')) {
                    $table->string('id_desa', 15)->nullable()->index()->after('id_kecamatan');
                    /*$table->foreign('id_desa')
                    ->references('kode_desa')->on('desa')
                    ->nullOnDelete();*/
                }

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
        /*Schema::table('users', function (Blueprint $table) {

        });*/
    }
}
