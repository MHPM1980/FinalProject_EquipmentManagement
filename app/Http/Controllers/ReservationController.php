<?php

namespace App\Http\Controllers;

use App\Reservation;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ReservationController extends Controller
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
        return Reservation::with(['user','product', 'warehouse'])->orderBy('id','asc')->paginate(15);
    }


    /**
     * Display Admin and Gestor dashboard card information.
     *
     */

    public function countReservations(Request $request){
        return response()->json(Reservation::where(
            "approved", "=", $request->approved
        )->count());
    }
    public function countPendReservations(Request $request){
        return response()->json(Reservation::where(
            "approved", "=", $request->approved
        )->count());
    }
    public function countReturReservations(Request $request){
        return response()->json(Reservation::where(
            "returned", "=", $request->returned
        )->count());
    }

    /**
     * Display Formador dashboard card information.
     *
     */

    public function countFormReservations(Request $request){
        $user=auth('api')->user();
        return response()->json(Reservation::where(
            "approved", "=", $request->approved
        )->where("user_id","=",$request->user_id)
            ->count());
    }
    public function countFormPendReservations(Request $request){
        return response()->json(Reservation::where(
            "approved", "=", $request->approved
        )->where("user_id","=",$request->user_id)
            ->count());
    }
    public function countFormReturReservations(Request $request){
        return response()->json(Reservation::where(
            "returned", "=", $request->returned
        )->where("user_id","=",$request->user_id)
            ->count());
    }

    /**
     * Search product reservations data
     *
     */

    public function productReservation(Request $request){
        response()->json(Reservation::where('product_id',$request->product_id)->whereIn('approved', [1])->orWhereNull('approved')->get()
            ->map(function($item){
                $period = CarbonPeriod::create($item->start_date, $item->end_date);
                // Iterate over the period
                foreach ($period as $date) {
                    echo $date->format('Y-m-d ');
                }
                return $item->dates = $period->toArray();
            }));
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
        $this->validate($request,[
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
            'registry_date' => 'required|date',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        try{
            return Reservation::create([
                'user_id' => $request['user_id'],
                'product_id' => $request['product_id'],
                'warehouse_id' => $request['warehouse_id'],
                'registry_date' => $request['registry_date'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
            ]);

        } catch (\Exception $exception){
            return response()->json(['error'=>$exception],500);
        }
    }

    public function reservationApproved(Request $request, $id){

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Find user in DB
        $reservation = Reservation::query()->findOrFail($id);

        $this->validate($request,[
            'approved'=> 'sometimes|boolean',
            'delivered'=> 'sometimes|boolean',
            'returned'=> 'sometimes|boolean',
        ]);

        try{
            $reservation -> approved = $request->approved;
            $reservation -> delivered = $request->delivered;
            $reservation -> returned = $request->returned;
            $reservation -> save();

            return['message'=>"Success"];

        }catch (\Exception $exception) {
            return response()->json(['error' => $exception], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
