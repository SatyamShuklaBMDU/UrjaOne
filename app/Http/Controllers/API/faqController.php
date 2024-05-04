<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class faqController extends Controller
{
    public function index(){
        $faqs = Faq::where('status','1')->get();
        if ($faqs->isEmpty()) {
            return response()->json(['message' => 'No FAQs found.'], 404);
        }
        return response()->json($faqs);
    }
}
