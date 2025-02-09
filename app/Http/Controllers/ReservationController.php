<?php

namespace App\Http\Controllers;

use App\Product;
use App\Reservation;
use App\User;
use App\Entity;
use App\Warehouse;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if(Auth::user()->role->name=='FORMADOR'){
            return tap(Reservation::with(['user','product'])->where("user_id", "=", Auth::user()->id)->orderBy('registry_date','desc')->paginate(9),function($paginatedInstance){
                return $paginatedInstance->getCollection()->transform(function ($reservation){
                    $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                    return $reservation;
                });
            });
        }else{
            return tap(Reservation::with(['user','product'])->orderBy('registry_date','desc')->paginate(9),function($paginatedInstance){
                return $paginatedInstance->getCollection()->transform(function ($reservation){
                    $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                    return $reservation;
                });
            });
        }
    }

    public function search(Request $request){
        if($search= \Request::get('q') && Auth::user()->role->name=='FORMADOR'){
            $search = $request->q;
            return Reservation::with(['user','product','warehouse.entity'])
                ->whereHas('user', function($query) use ($search){
                    $query->where('name','LIKE',"%$search%");
                })
                ->orWhereHas('product', function($query) use ($search){
                    $query->where('name','LIKE',"%$search%");
                })
                ->orWhereHas('warehouse', function($query) use ($search){
                    $query
                        ->where('name','LIKE',"%$search%")
                        ->orWhereHas('entity', function($query) use ($search){
                            $query->where('name','LIKE',"%$search%");
                        });
                })
                ->paginate(9);



        }else if($search= \Request::get('q') && Auth::user()->role->name!=='FORMADOR'){
            $search = $request->q;
            return Reservation::with(['user','product','warehouse.entity'])
                ->whereHas('user', function($query) use ($search){
                    $query->where('name','LIKE',"%$search%");
                })
                ->orWhereHas('product', function($query) use ($search){
                    $query->where('name','LIKE',"%$search%");
                })
                ->orWhereHas('warehouse', function($query) use ($search){
                    $query
                        ->where('name','LIKE',"%$search%")
                        ->orWhereHas('entity', function($query) use ($search){
                            $query->where('name','LIKE',"%$search%");
                        });
                })
                ->paginate(9);



        } else if(Auth::user()->role->name=='FORMADOR'){
            return tap(Reservation::with(['user','product'])->where("user_id", "=", Auth::user()->id)->orderBy('registry_date','desc')->paginate(9),function($paginatedInstance){
                return $paginatedInstance->getCollection()->transform(function ($reservation){
                    $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                    return $reservation;
                });
            });
        }else{
            return tap(Reservation::with(['user','product'])->orderBy('registry_date','desc')->paginate(9),function($paginatedInstance){
                return $paginatedInstance->getCollection()->transform(function ($reservation){
                    $reservation->warehouse = Warehouse::find($reservation->warehouse_id)->load(['entity']);

                    return $reservation;
                });
            });
        }

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
        return response()->json(Reservation::where(
            "approved", "=", $request->approved
        )->where("user_id","=",Auth::user()->id)
            ->count());
    }
    public function countFormPendReservations(Request $request){
        return response()->json(Reservation::where(
            "approved", "=", $request->approved
        )->where("user_id","=",Auth::user()->id)
            ->count());
    }
    public function countFormReturReservations(Request $request){
        return response()->json(Reservation::where(
            "returned", "=", $request->returned
        )->where("user_id","=",Auth::user()->id)
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
            })
        );
    }
    /**
     * Search Formador aproved reservations data
     *
     */

    public function getFormadorReservation(){
        response()->json(Reservation::where("user_id", "=", Auth::user()->id)->whereIn('approved', [1])->get()
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
        $reservation = Reservation::findOrFail($id);

        $this->validate($request,[
            'approved'=> 'sometimes|boolean',
            'delivered'=> 'sometimes|boolean',
            'returned'=> 'sometimes|boolean',
        ]);

        try{

            $reservation -> approved = $request->approved;
            $reservation -> delivered = $request->delivered;
            $reservation -> returned = $request->returned;

            if($reservation->approved == 1 && $reservation->delivered != 1 && $reservation->returned == null){
                $checkExistingReservation = Reservation::where('product_id', $reservation->product_id)
                    ->where('start_date', '>=', $reservation->end_date)
                    ->where('end_date', '<=', $reservation->start_date)
                    ->where('approved', '1')
                    ->get();

                if($checkExistingReservation->first() != null){
                    return response()->json(['error' => 'Já existe uma reserva aprovada para as datas definidas!'], 403);
                }
            }

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
    public function destroy($id)
    {
        //Find user in DB
        $reservation = Reservation::query()->findOrFail($id);
        //Delete user in DB
        $reservation->delete();

        return ['message' => 'Reservation Deleted'];
    }
}
