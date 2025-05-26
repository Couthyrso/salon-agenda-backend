<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());
        return response()->json($service, 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        return response()->json($service);
    }
    
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(null, 204);
    }
}
