<?php

namespace App\Http\Controllers;

use App\Cost;
use Illuminate\Http\Request;

class CostController extends Controller
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
        return Cost::with(['users'])->orderBy('id','asc')->paginate(15);
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
            'designation' => 'required|string|max:191',
            'description' => 'required|string',
        ]);

        try{
            return Cost::create([
                'designation' => $request['designation'],
                'description' => $request['description'],
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        try {
            return response()->json($cost->load(),200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find user in DB
        $cost = Cost::query()->findOrFail($id);

        //Validate new data
        $this->validate($request,[
            'designation' => 'required|string|max:191',
            'description' => 'required|string',
        ]);

        //update user in DB
        $cost->update($request->all());

        return ['message'=>'Updated the cost info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find cost in DB
        $cost = Cost::query()->findOrFail($id);
        //Delete cost in DB
        $cost->delete();

        return ['message' => 'User Deleted'];
    }
}
