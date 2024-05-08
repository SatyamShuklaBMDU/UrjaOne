<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', '!=', 'draft')->get();
        if ($blogs->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No Blog found.'], 404);
        }
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
        foreach ($blogs as $blog) {
            if ($blog->image !== null) {
                $blog->image = $baseUrl . $blog->image;
            }
            $blog->description = strip_tags($blog->description);
        }
        return response()->json(['status' => true, 'Blogs' => $blogs]);
    }

    public function incrementViews($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['status' => false, 'message' => 'Blog not found'], 404);
        }
        $blog->increment('views');
        $blog->refresh();
        $baseUrl = 'https://bmdublog.com/UrjaOne/public/';
        if ($blog->image) {
            $blog->image = $baseUrl . $blog->image;
        }
        $blog->description = strip_tags($blog->description);
        return response()->json([
            'status' => true,
            'message' => 'Views incremented',
            'views' => $blog->views,
            'blog' => $blog,
        ]);
    }

    public function incrementLikes($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['status' => false, 'message' => 'Blog not found'], 404);
        }
        $blog->increment('likes');
        return response()->json(['status' => true, 'message' => 'Likes incremented', 'likes' => $blog->likes]);
    }

}
