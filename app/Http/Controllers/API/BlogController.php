<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Customer;
use App\Models\Like;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

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
            $blog->description = $blog->description;
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

    public function toggleLike($id)
    {
        $user = Auth::user();
        if ($user instanceof Customer) {
            $likeableType = 'App\Models\Customer';
            $likeableId = $user->id;
        } elseif ($user instanceof Vendor) {
            $likeableType = 'App\Models\Vendor';
            $likeableId = $user->id;
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid user type'], 403);
        }
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['status' => false, 'message' => 'Blog not found'], 404);
        }
        try {
            $existingLike = Like::where('blog_id',$blog->id)->where('likeable_type', $likeableType)->where('likeable_id', $likeableId)->first();
            // dd();
            if ($existingLike) {
                $existingLike->delete();
                $blog->decrement('likes');
                return response()->json(['status' => true, 'message' => 'Like removed', 'likes' => $blog->likes]);
            } else {
                $like = new Like([
                    'likeable_type' => $likeableType,
                    'likeable_id' => $likeableId,
                    'blog_id' => $blog->id,
                ]);
                $like->save();
                $blog->increment('likes');
                return response()->json(['status' => true, 'message' => 'Like added', 'likes' => $blog->likes]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
