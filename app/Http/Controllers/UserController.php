<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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


       return User::with(['role','cost'])->orderBy('id','asc')->paginate(15);
    }

    public function search(){

        if($search= \Request::get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(15);

        }else{
            return User::with(['role','cost'])->orderBy('id','asc')->paginate(15);
        }
        return $users;

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
            'phone_number' => 'required|integer|digits:9',
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
    public function profile()
    {
        return auth('api')->user();
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
        //Find user in DB
        $user = User::query()->findOrFail($id);

        //Validate new data
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'role_id' => 'required|integer',
            'cost_id' => 'required|integer',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'phone_number' => 'required|integer|digits:9',
            'password' => 'sometimes|min:6',
        ]);

        //update user in DB
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->cost_id = $request->cost_id;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = bcrypt($request->password);
        $user->save();

       return ['message'=>'Updated the user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find user in DB
        $user = User::query()->findOrFail($id);
        //Delete user in DB
        $user->delete();

        return ['message' => 'User Deleted'];
    }
}
