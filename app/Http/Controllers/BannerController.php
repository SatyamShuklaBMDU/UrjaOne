<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\VendorBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return view('dashboard.Banners.main_banner');
    }

    public function VendorIndex()
    {
        return view('dashboard.Banners.vendor_main_banner');
    }

    public function UserBanner($name)
    {
        $users = Banner::where('for', $name)->get();
        return view('dashboard.Banners.User.banner', compact('users'));
    }

    public function VendorBanner($name)
    {
        $users = VendorBanner::where('for', $name)->get();
        return view('dashboard.Banners.Vendor.vendor_banner', compact('users'));
    }

    public function UserStore(Request $request)
    {
        $request->validate([
            'for' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('Banner/User/'), $imageName);
            $imagepath = 'Banner/User/' . $imageName;
            $banner = new Banner();
            $banner->for = $request->input('for');
            $banner->banner = $imagepath;
            $banner->save();
        }
        return redirect()->back()->with('success', 'Banner(s) uploaded successfully');
    }
    public function VendorStore(Request $request)
    {
        $request->validate([
            'for' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('Banner/Vendor/'), $imageName);
            $imagepath = 'Banner/Vendor/' . $imageName;
            $banner = new VendorBanner();
            $banner->for = $request->input('for');
            $banner->banner = $imagepath;
            $banner->save();
        }
        return redirect()->back()->with('success', 'Banner(s) uploaded successfully');
    }
    public function Vendordelete($id)
    {
        $blog = VendorBanner::findOrFail($id);
        $blog->delete();
        return response()->json(['success' => true]);
    }

    public function VendorEdit(Request $request)
    {
        $request->validate([
            'for' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        dd($request->image);
        if($request->hasFile($request->image)){
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('Banner/Vendor/'), $imageName);
            $imagepath = 'Banner/Vendor/' . $imageName;
            $banner = new VendorBanner();
            $banner->for = $request->input('for');
            $banner->banner = $imagepath;
            $banner->save();
        }
        return redirect()->back()->with('success', 'Banner(s) uploaded successfully');
    }
    public function UserEdit(Request $request)
    {
        $request->validate([
            'for' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($request->hasFile($request->image)){
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('Banner/User/'), $imageName);
            $imagepath = 'Banner/User/' . $imageName;
            $banner = new Banner();
            $banner->for = $request->input('for');
            $banner->banner = $imagepath;
            $banner->save();
        }
        return redirect()->back()->with('success', 'Banner(s) uploaded successfully');
    }
}
