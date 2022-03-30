<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use App\Http\Requests\BusRequest;
use App\Http\Resources\BusResource;
use Illuminate\Support\Facades\Gate;
use App\Repositories\BusesRepository;

class BusController extends Controller
{
    public $Bus;

    public function __construct(BusesRepository $Buses_Repository)
    {
        $this->Bus = $Buses_Repository;
    }
    public function index()
    {
        return BusResource::collection(Bus::all());
    }

    public function store(BusRequest $request)
    {

        if (!Gate::allows('bus_create', $request->user_id)) {
            abort(403);
        };

        $Bus=$this->Bus->createBuses($request->all());

        return response()->json(array('message' => 'وسیله نقلیه شما با موفقیت اضافه شد.'), 201);

    }

    public function update(BusRequest $request, Bus $bus)
    {
        if (!Gate::allows('bus_access', $bus)) {
            abort(403);
        };

        $bus->update($request->input());

        return response()->json(array('message' => 'وسیله نقلیه شما با موفقیت بروز رسانی شد'), 200);
    }

    public function destroy(Bus $bus)
    {
        if (!Gate::allows('bus_access', $bus)) {
            abort(403);
        };
        $archive = $this->Ticket->archive($bus->id);
        return response()->json(['message'=>$archive]);

    }
}
