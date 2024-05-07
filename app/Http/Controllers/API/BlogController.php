<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function incrementViews($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['status' => false, 'message' => 'Blog not found'], 404);
        }
        $blog->increment('views');
        return response()->json(['status' => true, 'message' => 'Views incremented', 'views' => $blog->views]);
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
