<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::all();

        $eventos = [];
        foreach ($reservas as $reserva) {
            $eventos[] = [
                'id' => $reserva->id,
                'title' => $reserva->nombre_huesped . ' (' . $reserva->habitacion . ')',
                'start' => $reserva->fecha_entrada->format('Y-m-d'),
                'end'   => $reserva->fecha_salida->format('Y-m-d'),
                'color' => $reserva->origen === 'Booking' ? '#0ea5e9' : '#10b981', 
                'allDay' => true,
                'extendedProps' => [
                    'huesped' => $reserva->nombre_huesped,
                    'habitacion' => $reserva->habitacion,
                    'precio' => $reserva->precio,
                    'telefono' => $reserva->telefono,
                    'email' => $reserva->email,
                    'observaciones' => $reserva->observaciones,
                    'origen' => $reserva->origen,
                    // Añadimos las fechas en formato crudo para el formulario de edición
                    'raw_start' => $reserva->fecha_entrada->format('Y-m-d'),
                    'raw_end' => $reserva->fecha_salida->format('Y-m-d'),
                ]
            ];
        }

        return view('reservas.index', compact('eventos'));
    }

    public function storeManual(Request $request)
    {
        $validated = $request->validate([
            'nombre_huesped' => 'required|string|max:255',
            'fecha_entrada'  => 'required|date',
            'fecha_salida'   => 'required|date|after:fecha_entrada',
            'habitacion'     => 'required|string|max:255',
            'precio'         => 'nullable|numeric',
            'telefono'       => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
            'observaciones'  => 'nullable|string',
        ]);

        try {
            $validated['origen'] = 'Manual';
            Reserva::create($validated);
            return redirect()->route('reservas.index')->with('success', '¡Reserva añadida correctamente!');
        } catch (\Exception $e) {
            Log::error('Error al guardar reserva manual: ' . $e->getMessage());
            return redirect()->route('reservas.index')->with('error', 'Hubo un error al guardar la reserva.');
        }
    }

    // NUEVO MÉTODO: Actualizar Reserva
    public function update(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'nombre_huesped' => 'required|string|max:255',
            'fecha_entrada'  => 'required|date',
            'fecha_salida'   => 'required|date|after:fecha_entrada',
            'habitacion'     => 'required|string|max:255',
            'precio'         => 'nullable|numeric',
            'telefono'       => 'nullable|string|max:50',
            'observaciones'  => 'nullable|string',
        ]);

        try {
            $reserva->update($validated);
            return redirect()->route('reservas.index')->with('success', '¡Reserva actualizada correctamente!');
        } catch (\Exception $e) {
            Log::error('Error al actualizar reserva: ' . $e->getMessage());
            return redirect()->route('reservas.index')->with('error', 'Hubo un error al actualizar la reserva.');
        }
    }

    // NUEVO MÉTODO: Eliminar Reserva
    public function destroy(Reserva $reserva)
    {
        try {
            $reserva->delete();
            return redirect()->route('reservas.index')->with('success', '¡Reserva eliminada con éxito!');
        } catch (\Exception $e) {
            Log::error('Error al eliminar reserva: ' . $e->getMessage());
            return redirect()->route('reservas.index')->with('error', 'No se pudo eliminar la reserva.');
        }
    }

    public function receiveWebhook(Request $request)
    {
        $validated = $request->validate([
            'nombre_huesped' => 'required|string|max:255',
            'fecha_entrada'  => 'required|date',
            'fecha_salida'   => 'required|date',
            'habitacion'     => 'required|string|max:255',
            'precio'         => 'nullable|numeric',
            'telefono'       => 'nullable|string|max:50',
            'email'          => 'nullable|email|max:255',
            'observaciones'  => 'nullable|string',
        ]);

        try {
            $validated['origen'] = 'Booking';
            $reserva = Reserva::create($validated);
            return response()->json(['status' => 'success', 'message' => 'Reserva registrada.', 'id' => $reserva->id], 201);
        } catch (\Exception $e) {
            Log::error('Error webhook Booking: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function exportarPDF(Request $request)
    {
        try {
            $fechaBase = $request->query('fecha', now()->format('Y-m-d'));
            $inicioSemana = Carbon::parse($fechaBase)->startOfWeek();
            $finSemana = Carbon::parse($fechaBase)->endOfWeek();

            $reservas = Reserva::where('fecha_entrada', '<=', $finSemana)
                               ->where('fecha_salida', '>=', $inicioSemana)
                               ->orderBy('fecha_entrada', 'asc')
                               ->get();

            $pdf = Pdf::loadView('pdf.reservas', compact('reservas', 'inicioSemana', 'finSemana'));
            return $pdf->stream('semana-' . $inicioSemana->format('d-m-Y') . '.pdf');
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el PDF.');
        }
    }
    public function mover(Request $request, $id)
{
    $reserva = \App\Models\Reserva::findOrFail($id);
    
    $reserva->update([
        'fecha_entrada' => $request->fecha_entrada,
        'fecha_salida' => $request->fecha_salida,
    ]);

    return response()->json(['success' => true]);
}
}