<?php

namespace App\Http\Controllers;

use App\Warehouse;
use App\Entity;
use Illuminate\Http\Request;

class WarehouseController extends Controller
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
        {
            return Warehouse::with(['entity'])->orderBy('id','asc')->paginate(15);
        }
    }

    public function search(){

        if($search= \Request::get('q')){
            $warehouses = Warehouse::with(['entity'])->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(15);


            return $warehouses;}
        else {
            return Warehouse::with(['entity'])->orderBy('id','asc')->paginate(15);
        }
    }

    public function warehouseSection(Request $request){
        return response()->json(Warehouse::where(
            "entity_id", "=", $request->entity_id
        )->get());
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
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:200',
            'address' => 'required|string',
            'phone_number' => 'required|integer|digits:9',
            'entity_id' => 'required|integer',
        ]);

        try{
            return Warehouse::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number'],
                'entity_id' => $request['entity_id'],
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        try {
            return response()->json($warehouse->load(),200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find user in DB
        $warehouse = Warehouse::query()->findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'description' => 'required|string|max:200',
            'address' => 'required|string',
            'phone_number' => 'required|integer|digits:9',
            'entity_id' => 'required|integer',
        ]);

        //update user in DB
        $warehouse->update($request->all());

        return ['message'=>'Updated the role info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find cost in DB
        $warehouse = Warehouse::query()->findOrFail($id);
        //Delete cost in DB
        $warehouse->delete();

        return ['message' => 'User Deleted'];
    }
}
