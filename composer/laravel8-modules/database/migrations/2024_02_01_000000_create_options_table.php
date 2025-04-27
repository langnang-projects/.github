<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Illuminate\Database\Migrations\Migration;
use App\Support\Module;

class CreateOptionsTable extends Migration
{
    protected $prefix = "";
    protected $tableName = "options";
    protected $status = "protected";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!$tableName = $this->getTableName())
            return;
        Schema::create($tableName, function (Blueprint $table) {
            $table->string('name');
            $table->string('description')->nullable();

            $table->string('type')->default('text')->nullable();
            $table->longText('value')->nullable();

            $table->integer('user_id')->default(0);

            $table->timestamps();
            // $table->timestamp('release_at')->nullable()->comment('发布时间');
            // $table->timestamp('deleted_at')->nullable()->comment('删除时间');

            $table->unique(['name', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!$tableName = $this->getTableName())
            return;
        Schema::dropIfExists($tableName);
    }
}