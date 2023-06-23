<?php

namespace App\Http\Controllers\inventory\warehouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventory\warehouse\LocationRequest;
use App\Models\inventory\warehouse\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::select(['id','location','remarks'])->get();
        return view('inventory.warehouse.location.main',compact('locations'));
    }

    public function store(LocationRequest $request)
    {
        Location::create($request->only(['location','remarks']));
        return redirect()->route('inventory.warehouse.location.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Location $location)
    {
        return response()->json(compact('location'));
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->only(['location','remarks']));
        return redirect()->route('inventory.warehouse.location.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('inventory.warehouse.location.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
