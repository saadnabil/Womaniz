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
        Schema::create('salon_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->foreignId('salon_id')->nullable()->constrained('salons')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('salon_branches');
    }
};
