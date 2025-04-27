<?php

use App\Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    protected $prefix = "";
    protected $tableName = "files";
    protected $status = "protected";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable()->unique()->comment('标识');

            $table->string('name')->nullable()->comment('标题');
            $table->string('extension')->nullable()->comment('扩展名');
            $table->string('path')->nullable()->comment('路径');

            $table->string('type')->nullable()->comment('类型');
            $table->string('status')->nullable()->comment('状态');

            $table->integer('template')->nullable()->default(0)->comment('模板');

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
        Schema::dropIfExists('files');
    }
}
