<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupToActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('activity_log')) {
            Schema::table('activity_log', function (Blueprint $table) {
                // example; change this.
                if (!Schema::hasColumn('activity_log', 'log_name')) {
                    $table->string('log_name', 191)->nullable()->index()->change();
                }
                if (!Schema::hasColumn('activity_log', 'group')) {
                    $table->string('group', 191)->nullable()->default('default')->index()->after('log_name');
                }
                if (!Schema::hasColumn('activity_log', 'description')) {
                    $table->longText('description')->nullable()->change();
                }
                if (!Schema::hasColumn('activity_log', 'subject_type')) {
                    $table->string('subject_type', 400)->nullable()->change();
                }
                if (!Schema::hasColumn('activity_log', 'causer_type')) {
                    $table->string('causer_type', 400)->nullable()->change();
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
        /*Schema::table('activity_log', function (Blueprint $table) {

        });*/
    }
}
