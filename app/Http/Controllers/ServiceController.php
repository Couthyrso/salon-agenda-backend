<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
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
        // Verifica se a requisição vem do admin
        if (request()->header('X-Admin-Request') === 'true') {
            return response()->json($service);
        }
        
        // Para clientes, verifica se o serviço não está deletado
        if ($service->trashed()) {
            return response()->json(['message' => 'Serviço não encontrado'], 404);
        }
        
        return response()->json($service);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        return response()->json($service);
    }
    
    public function destroy($id)
    {
        $service = Service::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
