<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Illuminate\Database\Migrations\Migration;
use App\Support\Module;

class CreateFieldsTable extends Migration
{
    protected $prefix = "";
    protected $tableName = "fields";
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
            $table->integer('id')->comment("内容编号");
            $table->string('name')->comment("字段名称");

            $table->string('type')->nullable()->comment("字段类型");

            // $table->integer('int_value')->nullable()->comment("整数");
            // $table->float('float_value')->nullable()->comment("小数");
            // $table->string('str_value')->nullable()->comment("小数");
            $table->longText('text_value')->nullable()->comment("文本");
            $table->longText('object_value')->nullable()->comment("对象");

            $table->timestamps();
            $table->timestamp('release_at')->nullable()->comment('发布时间');
            $table->timestamp('deleted_at')->nullable()->comment('删除时间');

            $table->unique(['id', 'name']);
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
