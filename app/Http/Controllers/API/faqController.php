<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class faqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('status', '1')->get();
        if ($faqs->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No FAQs found.'], 404);
        }
        return response()->json(['status' => true, 'message' => 'FAQ Done.', 'faqs' => $faqs]);
    }
}
