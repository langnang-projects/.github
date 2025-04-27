<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_contents', function (Blueprint $table) {
            $table->id('cid');

            $table->string('slug')->unique()->nullable();
            $table->string('ico')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();

            $table->string('type')->nullable()->default('post');
            $table->string('status')->nullable()->default('publish');

            $table->integer('order')->default(0);
            $table->integer('parent')->default(0);
            $table->integer('template')->default(0);

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
        Schema::dropIfExists('_contents');
    }
}
