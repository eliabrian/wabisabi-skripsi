<?php

namespace App\Http\Controllers\Admin;

use App\Detail;
use App\Product;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = Detail::all();
        return view('admin.details.index', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.details.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric|exists:products,id',
            'path' => 'required|image'
        ]);

        if ($validator->fails()) {
            return redirect('details/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $path = $request->path->store('products', 'public');

        Detail::create(array_merge($request->all(), [
            'path' => $path,
        ]));
        return redirect('/details')->with('status', 'Details created !');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail $detail)
    {
        $products = Product::all();
        return view('admin.details.edit', compact('detail', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail $detail)
    {
        $rules = [
            'product_id' => 'required|numeric|exists:products,id',
            'path' => 'image',
        ];

        $request->validate($rules);

        if($request->path){
            // dd($request->all());
            $path = $request->path->store('products', 'public');
            Detail::where('id', $detail->id)->update([
                'product_id' => $request->product_id,
                'path' => $path,
            ]);
            return redirect('/details')->with('status', 'Detail Updated !');
        }else{
            Detail::where('id', $detail->id)->update([
                'product_id' => $request->product_id
            ]);
            return redirect('/details')->with('status', 'Detail Updated !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail $detail)
    {
        Detail::destroy($detail->id);
        return redirect('/details')->with('status', 'Details deleted !');
    }
}
