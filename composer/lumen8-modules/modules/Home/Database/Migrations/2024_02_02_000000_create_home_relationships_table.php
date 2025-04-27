<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Support\Module;

class CreateHomeRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 基本关联表
        Schema::create(Module::currentConfig('db_prefix') . '_relationships', function (Blueprint $table) {
            $table->integer(Module::currentConfig('db_prefix') . '_mid')->nullable();
            $table->integer(Module::currentConfig('db_prefix') . '_cid')->nullable();
            $table->integer(Module::currentConfig('db_prefix') . '_lid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Module::currentConfig('db_prefix') . '_relationships');
    }
}
