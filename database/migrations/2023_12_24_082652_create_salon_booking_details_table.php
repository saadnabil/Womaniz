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
        Schema::create('salon_booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_branch_service_id')->nullable()->constrained('salon_branch_services')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_booking_id')->nullable()->constrained('salon_bookings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('expert_id')->nullable()->constrained('experts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_id')->nullable()->constrained('salons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_branch_id')->nullable()->constrained('salon_branches')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('time')->nullable();
            $table->date('day')->nullable();
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
        Schema::dropIfExists('salon_booking_details');
    }
};
