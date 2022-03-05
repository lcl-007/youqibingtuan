<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('分类名称');
            $table->integer('pid')->default(0)->comment('父级');
            $table->tinyInteger('status')->default(1)->comment('0:禁用，1:启用');
            $table->string('group')->default('goodes')->comment('分组');
            $table->tinyInteger('level')->default(1)->comment('分类级别1、2、3');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
