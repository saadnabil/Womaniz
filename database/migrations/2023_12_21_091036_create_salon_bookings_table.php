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
        Schema::create('salon_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salon_id')->nullable()->constrained('salons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('salon_branch_id')->nullable()->constrained('salon_branches')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('day')->nullable();
            $table->string('status')->dafault('not_confirmed');
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
        Schema::dropIfExists('salon_bookings');
    }
};
