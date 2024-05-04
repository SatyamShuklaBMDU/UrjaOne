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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('cin_no')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->text('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->double('coordinates',10,7)->nullable();
            $table->enum('category', ['residential', 'commercial', 'industrial', 'agricultural'])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('company_name');
            $table->string('landmark')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
