<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 11:58 PM ---------
 */

/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 8:41 PM ---------
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Support\Facades\Schema
     */
    protected $schema;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->schema = Schema::connection(
            config('eloquentviewable.models.view.connection')
        );

        $this->table = config('eloquentviewable.models.view.table_name');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( ! $this->schema->hasTable($this->table) ) {
            $this->schema->create($this->table, function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->morphs('viewable');
                $table->text('visitor')->nullable();
                $table->string('collection')->nullable()->index();
                $table->timestamp('viewed_at')->useCurrent()->index();
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
        Schema::dropIfExists($this->table);
    }
}
