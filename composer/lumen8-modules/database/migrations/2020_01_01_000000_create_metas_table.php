<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_metas', function (Blueprint $table) {
            $table->id('mid');

            $table->string('slug')->unique()->nullable();
            $table->string('ico')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->string('type')->nullable();
            $table->string('status')->nullable();

            $table->integer('order')->default(0);
            $table->integer('parent')->default(0);

            $table->integer('user')->default(0);
            $table->timestamps();
            $table->timestamp("release_at")->nullable();
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_metas');
    }
}
