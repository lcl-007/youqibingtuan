<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('下单的用户');
            $table->string('order_no')->comment('订单单号');
            $table->integer('amount')->comment('总金额，单位:分');
            $table->tinyInteger('status')->default(1)->comment('订单状态:1下单2支付3发货4收货');
            $table->timestamp('pay_time')->nullable()->comment('支付时间');
            $table->timestamps();
            $table->index('order_no');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
