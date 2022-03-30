<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Requests\TripRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\TripResource;
use App\Repositories\TripsRepository;

class TripController extends Controller
{
    public $Trip;

    public function __construct(TripsRepository $Trips_Repository)
    {
        $this->Trip  = $Trips_Repository;
    }
    public function index(SortRequest $request)
    {

        //use scope for sorting
        $trips =  Trip::date($request->date)
            ->origin($request->origin)
            ->price($request->price)
            ->busModel($request->bus_name)
            ->capacity($request->capacity)
            ->orderByDesc('departure_time')
            ->get();

        return  TripResource::collection($trips);
    }

    public function create(TripRequest $request)
    {
        if (!Gate::allows('bus_access', Bus::find($request->bus_id))) {
            abort(403);
        }

        $trip=$this->Trip->createtrip($request->all());


        return response()->json(
            array('message' => 'سفر شما با موفقیت اضافه شد'), 201
        );
    }

    public function update(TripRequest $request, Trip $trip)
    {//middleware
        if (!Gate::allows('bus_access', $trip->bus)) {
            abort(403);
        }
        if (!Gate::allows('bus_access', Bus::find($request->bus_id))) {
            abort(403);
        }

        $trip->update($request->input());

        return response()->json(
            array('message' => 'سفر شما بروز رسانی شد'),
            200
        );
    }
}
