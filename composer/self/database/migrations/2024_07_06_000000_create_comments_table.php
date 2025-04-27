<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Support\Module;

class CreateCommentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // 基本评论表
    Schema::create('_comments', function (Blueprint $table) {
      $table->id('coid');
      $table->integer('cid')->default(0)->comment("内容编号");

      $table->text("text")->nullable()->comment("内容");

      $table->integer("user")->default(0)->comment("用户编号");
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
    Schema::dropIfExists('_comments');
  }
}
