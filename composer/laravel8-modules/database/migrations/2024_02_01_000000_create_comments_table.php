<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Support\Module;

class CreateCommentsTable extends Migration
{
    protected $prefix = '';
    protected $tableName = 'comments';
    protected $status = "protected";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 基本评论表
        if (!$tableName = $this->getTableName())
            return;
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->integer('content')->default(0)->comment("内容编号");

            $table->text("text")->nullable()->comment("内容");

            $table->integer("user_id")->default(0)->comment("用户编号");

            $table->integer('parent')->default(0)->nullable()->comment('父本');

            $table->timestamps();
            $table->timestamp('release_at')->nullable()->comment('发布时间');
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
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
