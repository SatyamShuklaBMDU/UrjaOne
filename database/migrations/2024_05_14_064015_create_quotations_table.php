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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->unsignedBigInteger('enquiry_id');
            $table->foreign('enquiry_id')->references('id')->on('enquiries')->onDelete('cascade');
            $table->string('quotation_no')->unique();
            $table->string('lead_no');
            $table->string('price_per_kw')->nullable();
            $table->string('panel_warranty')->nullable();
            $table->string('inverter_warranty')->nullable();
            $table->string('technical_support')->nullable();
            $table->string('ac_cable_brand')->nullable();
            $table->string('dc_cable_brand')->nullable();
            $table->string('mms_structure')->nullable();
            $table->string('earthing')->nullable();
            $table->boolean('subsidy_support')->default(false);
            $table->boolean('metering_support')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
