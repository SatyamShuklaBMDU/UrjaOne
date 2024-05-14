<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id', 'enquiry_id', 'quotation_no', 'lead_no', 'price_per_kw',
        'panel_warranty', 'inverter_warranty', 'technical_support',
        'ac_cable_brand', 'dc_cable_brand', 'mms_structure', 'earthing',
        'subsidy_support', 'metering_support',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

}
