<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $appointment = Appointment::create([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Agendamento criado com sucesso',
            'data' => $appointment
        ], 201);
    }

    public function index()
    {
        $appointments = Appointment::with(['user', 'service'])->get();
        return response()->json($appointments);
    }

    public function show($id)
    {
        $appointment = Appointment::with(['user', 'service'])->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $appointment->update($request->only(['status', 'notes']));

        return response()->json([
            'message' => 'Agendamento atualizado com sucesso',
            'data' => $appointment
        ]);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json([
            'message' => 'Agendamento excluído com sucesso'
        ]);
    }
}
