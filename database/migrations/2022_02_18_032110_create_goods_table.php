<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('标题');
            $table->integer('user_id')->comment('创建者');
            $table->integer('category_id')->comment('分类');
            $table->string('description')->comment('描述');
            $table->integer('price')->comment('价格');
            $table->integer('sales')->comment('销量');
            $table->integer('stock')->comment('库存');
            $table->string('cover')->comment('封面图');
            $table->tinyInteger('is_on')->default(0)->comment('是否上架:0不上架，1上架');
            $table->tinyInteger('is_recommend')->default(0)->comment('是否推荐位：0不推荐，1推荐');
            $table->text('details')->comment('详情');
            $table->timestamp('time')->comment('活动时间');
            $table->timestamp('appointment')->comment('预约时间');
            $table->integer('people_num')->comment('报名人数');
            $table->timestamps();
            $table->index('category_id');
            $table->index('title');
            $table->index('is_on');
            $table->index('is_recommend');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
