<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Gestión de Reservas - Bar Equis</title>
    
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .fc-toolbar-title { font-size: 1.25rem !important; }
        .fc-button { text-transform: capitalize !important; }
        .fc-event { cursor: pointer; border: none; padding: 2px; }
        .fc-event-title { font-weight: bold; font-size: 0.8rem; white-space: normal !important; }
        /* Estilos para el popup de información */
        .swal-reserva-info { text-align: left !important; }
        .swal-reserva-info p { margin-bottom: 0.5rem; font-size: 0.95rem; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 h-screen flex flex-col overflow-hidden">

    <header class="bg-white shadow-sm p-4 flex justify-between items-center shrink-0 z-10">
        <h1 class="text-xl font-bold text-gray-800">🗓️ Mis Reservas</h1>
        
        <div class="flex items-center gap-2">
            <button onclick="toggleModal('modalImprimir')" class="bg-gray-800 text-white px-3 py-2 rounded-lg text-sm font-semibold shadow hover:bg-gray-700">
                📄 Imprimir
            </button>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm font-semibold shadow hover:bg-red-600">
                    Salir
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 p-2 overflow-hidden flex flex-col">
        <div class="bg-white p-3 rounded-xl shadow-sm flex-1 flex flex-col min-h-0">
            <div class="flex gap-4 mb-2 text-xs font-semibold justify-center shrink-0">
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-sky-500"></span> Booking</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Manual</span>
            </div>
            <div id='calendar' class="flex-1 min-h-0"></div>
        </div>
    </main>

    <button onclick="toggleModal('modalReserva')" class="fixed bottom-6 right-6 bg-emerald-500 text-white w-14 h-14 rounded-full shadow-lg text-3xl flex items-center justify-center hover:bg-emerald-600 transition z-20">
        +
    </button>

    <div id="modalReserva" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="p-5 border-b flex justify-between items-center sticky top-0 bg-white">
                <h2 class="text-lg font-bold">Añadir Reserva Manual</h2>
                <button onclick="toggleModal('modalReserva')" class="text-gray-500 text-2xl font-bold">&times;</button>
            </div>
            
            <form action="{{ route('reservas.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold mb-1">Nombre del Huésped *</label>
                    <input type="text" name="nombre_huesped" required class="w-full border rounded-lg p-2 focus:ring focus:ring-emerald-200">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Entrada *</label>
                        <input type="date" name="fecha_entrada" required class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Salida *</label>
                        <input type="date" name="fecha_salida" required class="w-full border rounded-lg p-2">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Habitación *</label>
                    <select name="habitacion" required class="w-full border rounded-lg p-2">
                        <option value="Habitación 1">Habitación 1</option>
                        <option value="Habitación 2">Habitación 2</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Teléfono</label>
                        <input type="text" name="telefono" class="w-full border rounded-lg p-2">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="w-full border rounded-lg p-2"></textarea>
                </div>
                <button type="submit" class="w-full bg-emerald-500 text-white font-bold py-3 rounded-lg mt-4 shadow hover:bg-emerald-600">
                    Guardar Reserva
                </button>
            </form>
        </div>
    </div>

    <div id="modalImprimir" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm">
            <div class="p-5 border-b flex justify-between items-center">
                <h2 class="text-lg font-bold">Imprimir Semana</h2>
                <button onclick="toggleModal('modalImprimir')" class="text-gray-500 text-2xl font-bold">&times;</button>
            </div>
            
            <form action="{{ route('reservas.pdf') }}" method="GET" target="_blank" class="p-5 space-y-4" onsubmit="toggleModal('modalImprimir')">
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Selecciona cualquier día de la semana que quieres imprimir:</label>
                    <input type="date" name="fecha" required value="{{ date('Y-m-d') }}" class="w-full border rounded-lg p-3 text-lg font-bold text-center">
                </div>
                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-lg mt-4 shadow hover:bg-gray-800">
                    Generar PDF
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventosLocales = {!! json_encode($eventos) !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                firstDay: 1,
                height: '100%',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                buttonText: {
                    today: 'Hoy'
                },
                events: eventosLocales,
                eventClick: function(info) {
                    // Extraemos todas las propiedades que preparamos en el controlador
                    var props = info.event.extendedProps;
                    
                    // Maquetamos la información de la reserva
                    var contenidoHTML = `
                        <div class="swal-reserva-info">
                            <p><strong>🚪 Habitación:</strong> ${props.habitacion}</p>
                            <p><strong>👤 Huésped:</strong> ${props.huesped}</p>
                            <p><strong>📅 Fechas:</strong> Del ${info.event.start.toLocaleDateString('es-ES')} al ${(info.event.end ? info.event.end.toLocaleDateString('es-ES') : info.event.start.toLocaleDateString('es-ES'))}</p>
                            <p><strong>💶 Precio:</strong> ${props.precio ? props.precio + ' €' : 'No especificado'}</p>
                            <hr class="my-3">
                            <p><strong>📞 Teléfono:</strong> ${props.telefono ? props.telefono : '-'}</p>
                            <p><strong>✉️ Email:</strong> ${props.email ? props.email : '-'}</p>
                            <p><strong>📝 Observaciones:</strong> ${props.observaciones ? props.observaciones : 'Ninguna'}</p>
                            <p class="mt-3 text-xs text-gray-400">Origen de la reserva: ${props.origen}</p>
                        </div>
                    `;

                    Swal.fire({
                        title: 'Detalles de Reserva',
                        html: contenidoHTML,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#10b981'
                    });
                }
            });
            calendar.render();

            @if(session('success'))
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false, timer: 3000
                });
            @endif
        });
    </script>
</body>
</html>