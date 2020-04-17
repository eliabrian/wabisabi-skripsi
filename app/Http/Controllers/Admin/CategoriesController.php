<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('categories/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Category::create($request->all());

        return redirect('/categories')->with('status', 'Category created !');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $request->validate($rules);

        Category::where('id', $category->id)->update([
            'name' => $request->name,
        ]);

        return redirect('/categories')->with('status', 'Category updated !');
    }

    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        return redirect('categories')->with('status', 'Category deleted !');
    }
}
