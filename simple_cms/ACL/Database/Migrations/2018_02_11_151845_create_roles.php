<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/30/20 10:41 AM ---------
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! Schema::hasTable('roles') )
        {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('slug',60)->index()->unique();
                $table->string('name',50)->index();
                $table->text('permissions')->nullable();
                $table->string('description',150)->nullable();
                $table->softDeletes()->index();
                $table->timestamps();

                $table->index('created_at', 'roles_created_at_index');
                $table->index('updated_at', 'roles_updated_at_index');
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
        Schema::dropIfExists('roles');
    }
}
