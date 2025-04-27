<?php

use App\Support\Helpers\ModuleHelper;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;
use App\Support\Module;

class CreateMetasTable extends Migration
{
    protected $prefix = "";
    protected $tableName = "metas";
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
        // 基本标记表
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable()->unique()->comment('标识');
            $table->string('ico')->nullable()->comment('徽标');
            $table->string('name')->nullable()->comment('标题');
            $table->string('description')->nullable()->comment('描述');

            $table->string('type')->nullable()->comment('类型');
            $table->string('status')->nullable()->comment('状态');

            $table->integer('count')->nullable()->default(0)->comment('计数');
            $table->integer('order')->nullable()->default(0)->comment('权重');
            $table->integer('parent')->nullable()->default(0)->comment('父本');

            $table->integer("user_id")->default(0)->comment("用户编号");

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
