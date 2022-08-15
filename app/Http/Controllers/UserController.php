<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return User::with(['role','cost'])->orderBy('id','asc')->paginate(15);
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
            'role_id' => 'required|integer',
            'cost_id' => 'required|integer',
            'email' => 'required|string|email|max:191|unique:users',
            'phone_number' => 'required|integer',
            'password' => 'required|string|min:6',
        ]);

        try{
            return User::create([
                'role_id' => $request['role_id'],
                'cost_id' => $request['cost_id'],
                'name' => $request['name'],
                'email' => $request['email'],
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($request['password'])
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {
            return response()->json($user->load(['role','cost']),200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $user->update($request->all());
            $user->roles()->sync($request->roles);
            $user->cost_centers()->sync($request->cost_centers);
            return response()->json($user->load(['role','cost']),201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json(['message' => 'Deleted'], 205);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }
    }
}
