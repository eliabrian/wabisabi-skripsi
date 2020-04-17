<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Category;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'required|string|min:5',
            'category_id' => 'required|numeric|exists:categories,id',
            'thumbnail' => 'required|image',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('products/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $path = $request->thumbnail->store('thumbnail', 'public');
        $image = Image::make(public_path("/storage/{$path}"))->orientate()->fit(600, 360);
        $image->save();

        Product::create(array_merge($request->all(), [
            'thumbnail' => $path,
        ]));

        return redirect('/products')->with('status', 'Product created !');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'desc' => 'required|string|min:5',
            'category_id' => 'required|numeric|exists:categories,id',
            'thumbnail' => 'image',
            'price' => 'required|numeric',
            'stock' => 'required|numeric'
        ];

        $request->validate($rules);

        if($request->thumbnail){
            $path = $request->thumbnail->store('thumbnail', 'public');
            $image = Image::make(public_path("/storage/{$path}"))->orientate()->fit(600, 360);
            $image->save();


            Product::where('id', $product->id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'thumbnail' => $path,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);
            return redirect('products')->with('status', 'Product updated !');
        }else{
            Product::where('id', $product->id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'stock' => $request->stock,
            ]);
            return redirect('products')->with('status', 'Product updated !');
        }

        
    }

    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        return redirect('products')->with('status', 'Product deleted !');
    }
}
