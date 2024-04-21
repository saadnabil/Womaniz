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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->text('hq_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->double('commission')->nullable();
            $table->string('transfer_method')->nullable(); // iban, bankaccount, swift
            $table->string('bank_account_name')->nullable(); //bankaccount
            $table->string('account_number')->nullable(); //bankaccount
            $table->string('swift_number')->nullable(); //swift
            $table->string('iban_number')->nullable(); //swift
            $table->string('image')->nullable();
            $table->tinyinteger('status')->default(1);
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('vendors');
    }
};
