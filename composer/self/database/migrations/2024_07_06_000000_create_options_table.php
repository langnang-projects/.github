<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Support\Module;

class CreateOptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('_options', function (Blueprint $table) {
      $table->string('name');
      $table->string('type')->default('string');
      $table->string('value');

      $table->integer('user')->default(0);

      $table->timestamps();
      $table->timestamp('release_at')->nullable()->comment('发布时间');
      $table->timestamp('deleted_at')->nullable()->comment('删除时间');

      $table->unique(['name', 'user']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('_options');
  }
}
