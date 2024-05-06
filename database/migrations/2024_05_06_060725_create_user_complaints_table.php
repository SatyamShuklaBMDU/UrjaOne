<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE');
            $table->text('message');
            $table->unsignedBigInteger('reply_person_id')->nullable();
            $table->foreign('reply_person_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('reply')->nullable();
            $table->enum('status',['follow','confirm'])->default('follow');
            $table->timestamp('reply_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_complaints');
    }
};
