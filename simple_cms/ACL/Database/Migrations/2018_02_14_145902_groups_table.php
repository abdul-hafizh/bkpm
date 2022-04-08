<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/30/20 10:42 AM ---------
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('groups') )
        {
            Schema::create('groups', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('slug',60)->index()->unique();
                $table->string('name',50)->unique()->index();
                $table->text('description')->nullable();
                $table->softDeletes()->index();
                $table->timestamps();

                $table->index('created_at', 'groups_created_at_index');
                $table->index('updated_at', 'groups_updated_at_index');
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
        Schema::dropIfExists('groups');
    }
}
