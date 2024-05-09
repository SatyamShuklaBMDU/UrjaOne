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
        $users = Banner::where('for', $name)->latest()->get();
        return view('dashboard.Banners.User.banner', compact('users','name'));
    }

    public function VendorBanner($name)
    {
        $users = VendorBanner::where('for', $name)->latest()->get();
        return view('dashboard.Banners.Vendor.vendor_banner', compact('users','name'));
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
    public function Userdelete($id)
    {
        $blog = Banner::findOrFail($id);
        $blog->delete();
        return response()->json(['success' => true]);
    }

    public function VendorEdit(Request $request)
    {
        $request->validate([
            'for' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('Banner/Vendor/'), $imageName);
            $imagepath = 'Banner/Vendor/' . $imageName;
            $banner = VendorBanner::find($request->bannerId);
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
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('Banner/User/'), $imageName);
            $imagepath = 'Banner/User/' . $imageName;
            $banner = Banner::find($request->bannerId);
            $banner->for = $request->input('for');
            $banner->banner = $imagepath;
            $banner->save();
        }
        return redirect()->back()->with('success', 'Banner(s) uploaded successfully');
    }

    public function filterdataVendor(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        // dD($request->all());
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $users = VendorBanner::where('for',$request->for)->whereBetween('created_at', [$startDate, $endDate])->get();
        return view('dashboard.Banners.Vendor.vendor_banner', ['users' => $users, 'start' => $startDate, 'end' => $endDate, 'name' => $request->for]);
    }
    public function filterdata(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);
        // dD($request->all());
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $users = Banner::where('for',$request->for)->whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($users);
        return view('dashboard.Banners.User.banner', ['users' => $users, 'start' => $startDate, 'end' => $endDate, 'name' => $request->for]);
    }
    public function statuschange(Request $request)
    {
        // dd($request->all());    
        $status = $request->input('status');
        try {
            $vendor = Banner::findOrFail($request->banner);
            $vendor->status = $status;
            $vendor->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function statusVendorchange(Request $request)
    {
        // dd($request->all());    
        $status = $request->input('status');
        try {
            $vendor = VendorBanner::findOrFail($request->banner);
            $vendor->status = $status;
            $vendor->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
