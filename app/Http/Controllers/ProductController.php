<?php

namespace App\Http\Controllers;

use App\Product;
use App\Warehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return tap(Product::with(['category', 'reservations'])->orderBy('id','asc')->paginate(5),function($paginatedInstance){
            return $paginatedInstance->getCollection()->transform(function ($reservation){
                $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                return $reservation;
            });
        });
    }

    public function search(){
        if($search= \Request::get('q')){
            return tap(Product::with(['category'])->orderBy('id','asc')->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('description','LIKE',"%$search%")
                    ->orWhere('serial_number','LIKE',"%$search%");
            })->paginate(5),function($paginatedInstance){
                return $paginatedInstance->getCollection()->transform(function ($reservation){
                    $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                    return $reservation;
                });
            });

        }
        else {
            return tap(Product::with(['category'])->orderBy('id','asc')->paginate(5),function($paginatedInstance){
                return $paginatedInstance->getCollection()->transform(function ($reservation){
                    $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                    return $reservation;
                });
            });
        }
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
            'image'=> 'required|string',
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:200',
            'serial_number' => 'required|string',
            'category_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
        ]);

        if($request->image){
            $name =time().'.'.explode('/',explode(':', substr($request->image,0,strpos($request->image,';')))[1])[1];
            \Image::make($request->image)->save(public_path('img/products/').$name);

        }

        try{
            return Product::create([
                'image' => $name,
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
        try {
            return response()->json($product->load(),200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find user in DB
        $product = Product::query()->findOrFail($id);

        $this->validate($request,[
            'image'=> 'sometimes|string',
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:200',
            'serial_number' => 'required|string',
            'category_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
        ]);

        $currentImage = $product->image;
        if($request->image != $currentImage){
            $name =time().'.'.explode('/',explode(':',
                    substr($request->image,0,strpos($request->image,';')))[1])[1];
            \Image::make($request->image)->save(public_path
                ('img/products/').$name);

            $request->merge(['image' => $name]);

            $productImage=public_path('img/products/'.$currentImage);

            if(file_exists($productImage)){
                @unlink($productImage);
            }
        }

        try {

            //update user in DB
            $product->update($request->all());

            return ['message'=>'Updated the product info'];

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find product in DB
        $product = Product::query()->findOrFail($id);

        //Delete product and image in DB
        $image_path = public_path().'/img/products/'.$product->image;
        unlink($image_path);
        $product->delete();

        return ['message' => 'User Deleted'];
    }
}
