<?php

namespace App\Http\Controllers\master_data;

use App\Http\Controllers\Controller;
use App\Http\Requests\master_data\ServiceRequest;
use App\Models\master_data\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::select(['id','name','remarks'])->get();
        return view('master_data.services.main',compact('services'));
    }

    public function store(ServiceRequest $request)
    {
        Service::create($request->only(['name','remarks']));
        return redirect()->route('services.index')->with('success',config('constants.SUCCESS_SAVE'));
    }

    public function edit(Service $service){
        return response()->json($service);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->where('id',$service->id)->update($request->only(['name','remarks']));

        return redirect()->route('services.index')->with('success',config('constants.SUCCESS_UPDATE'));
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success',config('constants.SUCCESS_DELETE'));
    }
}
