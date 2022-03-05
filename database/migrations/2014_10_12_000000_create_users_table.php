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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('hy_id')->comment('会员id');
            $table->string('name');
            $table->string('avatar')->comment('会员头像');
            $table->integer('phone')->comment('手机号');
            $table->integer('integral')->comment('积分');
            $table->integer('coupon')->comment('优惠券');
            $table->integer('allmoney')->comment('总资产');
            $table->integer('is_locked')->comment('用户状态:0禁用1启用');
            $table->string('open_id')->comment('腾讯接口');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
