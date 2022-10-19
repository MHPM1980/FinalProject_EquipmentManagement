<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        return Role::with(['users'])->orderBy('id','asc')->paginate(15);
    }
    public function search(){

        if($search= \Request::get('q')){
            $roles = Role::with(['users'])->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(15);


            return $roles;}
        else {
            return Role::with(['users'])->orderBy('id','asc')->paginate(15);
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
            'name' => 'required|string|max:191',
        ]);

        try{
            return Role::create([
                'name' => $request['name'],
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        try {
            return response()->json($role->load(),200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find user in DB
        $role = Role::query()->findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
        ]);

        //update user in DB
        $role->update($request->all());

        return ['message'=>'Updated the role info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find user in DB
        $role = Role::query()->findOrFail($id);
        //Delete user in DB
        $role->delete();

        return ['message' => 'User Deleted'];
    }
}
