<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        \Cart::session($id);
        $items = \Cart::getContent();

        

        return view('carts.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'thumbnail' => 'required|string',
        ];

        $request->validate($rules);

        $id = Auth::id();
        \Cart::session($id)->add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'thumbnail' => $request->thumbnail,
            )
        ));

        return redirect('carts')->with('status','Item(s) has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idUser = Auth::id();
        \Cart::session($idUser);
        \Cart::remove($id);
        return redirect('carts')->with('status','Item(s) has been removed.');
    }

    public function increment($id)
    {
        $idUser = Auth::id();
        \Cart::session($idUser);

        $product = Product::find($id);
        $cart = \Cart::get($id);
        
        if($cart->quantity >= $product->stock){
            \Cart::update($id, 
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $product->stock,
                ),
            ));
            return redirect('carts')->with('status', "Quantity cannot be greater than stock!");

        }else{
            \Cart::update($id, 
            array(
                'quantity' => +1,
            ));
            return redirect('carts');
        }

    }

    public function decrement($id)
    {
        $idUser = Auth::id();
        \Cart::session($idUser);

        \Cart::update($id, 
            array(
                'quantity' => -1,
            ));
        return redirect('carts');
    }
}
