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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE');
            $table->string('lead_no')->unique();
            $table->enum('category', ['residential', 'commercial', 'industrial', 'agricultural'])->nullable();
            $table->string('plant_load')->nullable();
            $table->boolean('subsidy')->default(false);
            $table->boolean('finance')->default(false);
            $table->text('structure_type')->nullable();
            $table->text('solar_panel_type')->nullable();
            $table->text('panel_brands')->nullable();
            $table->text('inverter_brands')->nullable();
            $table->text('book_plant_time')->nullable();
            $table->string('total_quotation')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
