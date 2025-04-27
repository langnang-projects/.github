<?php


use App\Support\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateContentsTable extends Migration
{
    protected $prefix = "";
    protected $tableName = "contents";
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
        // 基本内容表
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable()->unique()->comment('标识');
            $table->string('ico')->nullable()->comment('徽标');

            $table->string('title')->nullable()->comment('标题');
            $table->string('description')->nullable()->comment('描述');
            $table->longText('text')->nullable()->comment('内容');

            $table->string('type', 16)->nullable()->comment('类型');
            $table->string('status', 16)->nullable()->comment('状态');

            $table->integer('template')->default(0)->nullable()->comment('模板');
            $table->integer('views')->default(0)->nullable()->comment('视图');

            $table->integer('count')->default(0)->nullable()->comment('计数');
            $table->integer('order')->default(0)->nullable()->comment('权重');
            $table->integer('parent')->default(0)->nullable()->comment('父本');

            $table->integer("user_id")->default(0)->comment("用户编号");
            // $table->json("modules")->nullable()->comment("关联模块");
            $table->timestamps();
            $table->timestamp('release_at')->nullable()->comment('发布时间');
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');
        });

        // Schema::create("_contents", function (Blueprint $table) {
        //     $table->string("module")->primary();
        //     $table->string("cid")->primary();
        //     $table->string("title");
        //     $table->string("description");
        // });
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
