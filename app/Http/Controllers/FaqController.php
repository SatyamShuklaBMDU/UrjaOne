<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('dashboard.faq', compact('faqs'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);
        Faq::create($validatedData);
        return response()->json(['success' => 'FAQ created successfully']);
    }
    public function updateStatus(Request $request)
    {
        $faq = FAQ::findOrFail($request->faq_id);
        $faq->status = $request->status;
        $faq->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
    public function edit($id)
    {
        $faq = FAQ::findOrFail($id);
        return response()->json($faq);
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        $faq = FAQ::findOrFail($request->faq_id);
        $faq->title = $request->input('title');
        $faq->description = $request->input('description');
        $faq->save();
        return response()->json(['success' => true]);
    }
    public function delete($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();
        return response()->json(['success' => true]);
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $faqs = Faq::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.faq', ['faqs' => $faqs, 'start' => $startDate, 'end' => $endDate]);
    }
}
