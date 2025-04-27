<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // 基本用户表
    Schema::create('_users', function (Blueprint $table) {
      $table->id("uid")->comment("用户编号");

      $table->string('name')->nullable()->comment("用户名称");
      $table->string('slug')->nullable()->comment("用户编码");
      $table->string('role')->nullable()->default('guest')->comment("用户角色\n- system-admin\n- admin,vip-user,user,guest");
      $table->string('permission')->nullable()->comment("用户权限");
      $table->string('email')->nullable()->unique();
      $table->timestamp('email_verified_at')->nullable()->nullable();
      $table->string('password')->nullable();
      $table->rememberToken();

      $table->timestamps();
      $table->timestamp('release_at')->nullable()->comment('发布时间');
      $table->timestamp('deleted_at')->nullable()->comment('删除时间');
      // $table->comment('基础用户表');
    });
    // Schema::create('user_fields', function (Blueprint $table) {
    //     $table->id()->comment("用户编号");

    //     $table->string('name')->nullable()->comment("用户名称");
    //     $table->string('slug')->nullable()->comment("用户编码");
    //     $table->string('role')->nullable()->default('guest');
    //     $table->string('email')->nullable()->unique();
    //     $table->timestamp('email_verified_at')->nullable()->nullable();
    //     $table->string('password')->nullable();
    //     $table->rememberToken();

    //     $table->timestamps();
    //     $table->timestamp('release_at')->nullable()->comment('发布时间');
    //     $table->timestamp('deleted_at')->nullable()->comment('删除时间');
    //     // $table->comment('用户表');
    // });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('_users');
  }
}
