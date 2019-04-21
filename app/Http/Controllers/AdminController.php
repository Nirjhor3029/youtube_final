<?php

namespace App\Http\Controllers;

use App\Admin;
use App\VdoCategory;
use App\VdoSubCategory;
use App\Video;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalCategory = VdoCategory::all()->count();
        $totalSubCategory = VdoSubCategory::all()->count();
        $totalVideo = Video::all()->count();
        $totalTag = Video::all()->count();

        $adminUsers = Admin::all();

        //return $adminUsers;

        //return $totalVideo;

        return view('admin.index')
            ->with('totalCategory',$totalCategory)
            ->with('totalSubCategory',$totalSubCategory)
            ->with('totalVideo',$totalVideo)
            ->with('totalTag',$totalTag)
            ->with('adminUsers',$adminUsers);
    }


}
