<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Illuminate\Database\Migrations\Migration;
use App\Support\Module;

class CreateRelationshipsTable extends Migration
{
    protected $prefix = "";
    protected $tableName = "relationships";
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
        // 基本关联表
        Schema::create($tableName, function (Blueprint $table) {
            $table->integer('meta_id')->nullable()->comment("Meta");
            $table->integer('content_id')->nullable()->comment("Content");
            $table->integer('link_id')->nullable()->comment("Link");
            $table->integer('file_id')->nullable()->comment("File");
            foreach (\Module::allEnabled() as $moduleName => $moduleObject) {
                $table->integer($moduleObject->getAlias() . '_id')->nullable()->comment($moduleName);
            }
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
