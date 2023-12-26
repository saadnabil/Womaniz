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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->tinyinteger('is_salon')->default(0);
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade')->onupdate('cascade');

            $table->string('image')->nullable();

            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->softDeletes();
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
};
