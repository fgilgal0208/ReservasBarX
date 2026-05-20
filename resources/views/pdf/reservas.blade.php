<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Reservas</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .badge {
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-booking { background-color: #e0f2fe; color: #0369a1; }
        .badge-manual { background-color: #f3f4f6; color: #374151; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Cuadrante de Reservas</h1>
        <p>Semana del <strong>{{ $inicioSemana->format('d/m/Y') }}</strong> al <strong>{{ $finSemana->format('d/m/Y') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Huésped</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Habitación</th>
                <th>Precio</th>
                <th>Origen</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservas as $reserva)
                <tr>
                    <td>
                        <strong>{{ $reserva->nombre_huesped }}</strong>
                        @if($reserva->telefono) <br><small>Tel: {{ $reserva->telefono }}</small> @endif
                    </td>
                    <td>{{ $reserva->fecha_entrada->format('d/m/Y') }}</td>
                    <td>{{ $reserva->fecha_salida->format('d/m/Y') }}</td>
                    <td>{{ $reserva->habitacion }}</td>
                    <td>{{ $reserva->precio ? number_format($reserva->precio, 2, ',', '.') . '€' : '-' }}</td>
                    <td>
                        <span class="badge {{ $reserva->origen === 'Booking' ? 'badge-booking' : 'badge-manual' }}">
                            {{ $reserva->origen }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay reservas programadas para esta semana.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>