<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->double('total')->nullable();
            $table->double('totalsub')->nullable();
            $table->double('payment_method')->default('cash')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
