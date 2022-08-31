<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with(['category','warehouse'])->orderBy('id','asc')->paginate(15);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'image'=> 'required|string|max:191',
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:200',
            'serial_number' => 'required|string',
            'category_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
        ]);

        try{
            return Product::create([
                'image' => $request['image'],
                'name' => $request['name'],
                'description' => $request['description'],
                'serial_number' => $request['serial_number'],
                'category_id' => $request['category_id'],
                'warehouse_id' => $request['warehouse_id'],
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find cost in DB
        $product = Product::query()->findOrFail($id);
        //Delete cost in DB
        $product->delete();

        return ['message' => 'User Deleted'];
    }
}
