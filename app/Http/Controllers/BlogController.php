<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('dashboard.Blogs.blog', compact('blogs'));
    }

    public function AddBlogs()
    {
        return view('dashboard.Blogs.add_blog');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:20',
            'category' => 'required|string',
            'description' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,png,gif|max:2048', // 2MB Max
            'status' => 'required|in:draft,published',
        ]);

        $blog = new Blog($validatedData);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->image->extension();
            $photoPath = $request->file('image')->move(public_path('Blog/'), $photoFileName);
            $photoRelativePath = 'Blog/' . $photoFileName;
            $blog->image = $photoRelativePath;
        }
        $blog->save();
        return redirect()->route('get-blog-page')->with('success', 'Blog created successfully!');
    }

    public function update(Request $request,)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);
        $blog = Blog::find($request->blogId);
        $blog->update($request->only(['title', 'category', 'description', 'status']));
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $photoFileName = uniqid() . '.' . $request->image->extension();
            $photoPath = $request->file('image')->move(public_path('Blog/'), $photoFileName);
            $photoRelativePath = 'Blog/' . $photoFileName;
            $blog->image = $photoRelativePath;
        }
        $blog->save();
        return redirect()->route('get-blog-page')->with('success', 'Blog updated successfully!');
    }
    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
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
        $blogs = Blog::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Blogs.blog', ['blogs' => $blogs, 'start' => $startDate, 'end' => $endDate]);
    }
}
