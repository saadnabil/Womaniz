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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('size_id')
                  ->nullable()
                  ->constrained('sizes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained('products')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->integer('stock')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
};
