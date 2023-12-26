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
        Schema::create('salon_branch_services', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->double('price')->nullable();
            $table->double('price_after_sale')->nullable();
            $table->tinyinteger('discount')->default(0);
            $table->foreignId('country_id')->constrained('countries')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_branch_id')->constrained('salon_branches')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('salon_branch_services');
    }
};
