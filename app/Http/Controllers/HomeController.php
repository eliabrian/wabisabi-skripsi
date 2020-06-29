<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $latest_category = Category::latest()->get();
        $new_categories = $latest_category->take(3);
        return view('home', compact('categories', 'new_categories'));
    }
}
