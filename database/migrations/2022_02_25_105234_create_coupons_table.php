<?php

use App\Models\comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('goods_id');
            $table->integer('user_id');
            $table->string('title')->comment('优惠券名称');
            $table->integer('price')->comment('优惠券金额');
            $table->string('content')->comment('描述');
            $table->integer('ison')->comment('是否启用优惠券');
            $table->timestamp('time')->comment('有效期');
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
        Schema::dropIfExists('coupons');
    }
}
