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
        Schema::create('salon_branch_expert_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->constrained('salons')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_branch_id')->constrained('salon_branches')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('expert_id')->constrained('experts')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->string('day')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
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
        Schema::dropIfExists('salon_branch_expert_times');
    }
};
