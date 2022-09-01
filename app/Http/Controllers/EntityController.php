<?php

namespace App\Http\Controllers;

use App\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Entity::with(['warehouses'])->orderBy('id','asc')->paginate(15);
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
            'address' => 'required|string',
            'phone_number' => 'required|integer',
        ]);

        try{
            return Entity::create([
                'name' => $request['name'],
                'address' => $request['address'],
                'phone_number' => $request['phone_number']
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function show(Entity $entity)
    {
        try {
            return response()->json($entity->load(),200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find user in DB
        $entity = Entity::query()->findOrFail($id);

        //Validate new data
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'address' => 'required|string',
            'phone_number' => 'required|integer',
        ]);

        //update user in DB
        $entity->update($request->all());

        return ['message'=>'Updated the entity info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find user in DB
        $user = Entity::query()->findOrFail($id);
        //Delete user in DB
        $user->delete();

        return ['message' => 'User Deleted'];
    }
}
