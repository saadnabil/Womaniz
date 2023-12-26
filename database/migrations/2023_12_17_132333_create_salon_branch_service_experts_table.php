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
        Schema::create('salon_branch_service_experts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expert_id')->nullable()->constrained('experts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_branch_service_id')->nullable()->constrained('salon_branch_services')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('salon_branch_service_experts');
    }
};
