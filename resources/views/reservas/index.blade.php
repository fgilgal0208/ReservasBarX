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
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Tipografía y estilos base del calendario */
        .fc-toolbar-title { font-size: 1.25rem !important; color: #1f2937; }
        .fc-button { text-transform: capitalize !important; font-weight: 600 !important; }
        
        /* Estética de las cajitas de reserva (Escritorio) */
        .fc-event { cursor: pointer; border: none; padding: 3px 5px; border-radius: 4px; margin-bottom: 2px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .fc-event-title { font-weight: 700; font-size: 0.75rem; white-space: normal !important; line-height: 1.1; word-break: break-word; }
        
        /* Magia Responsiva: Adaptaciones para el móvil */
        @media (max-width: 768px) {
            /* Apilar el encabezado */
            .fc-header-toolbar {
                flex-direction: column;
                gap: 12px;
                margin-bottom: 1rem !important;
            }
            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                width: 100%;
            }
            .fc-toolbar-title {
                font-size: 1.1rem !important;
                text-align: center;
            }
            /* Encoger las cajas de reserva y el texto al máximo */
            .fc-event { padding: 1px 3px; border-radius: 3px; }
            .fc-event-title { font-size: 0.6rem !important; line-height: 1; }
        }

        .swal-reserva-info { text-align: left !important; }
        .swal-reserva-info p { margin-bottom: 0.5rem; font-size: 0.95rem; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 h-screen flex flex-col overflow-hidden">

    <header class="bg-white shadow-sm p-4 flex justify-between items-center shrink-0 z-10 border-b border-gray-200">
        <img src="{{ asset('img/logo.jpg') }}" alt="Bar Equis" class="h-10 object-contain">
        
        <div class="flex items-center gap-2">
            <button onclick="toggleModal('modalImprimir')" class="bg-gray-800 text-white px-3 py-2 rounded-lg text-sm font-semibold shadow hover:bg-gray-700 transition">
                📄 Imprimir
            </button>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg text-sm font-semibold shadow hover:bg-red-600 transition">
                    Salir
                </button>
            </form>
        </div>
    </header>

    <main class="flex-1 p-2 md:p-4 overflow-hidden flex flex-col">
        <div class="bg-white p-3 rounded-2xl shadow-sm flex-1 flex flex-col min-h-0 border border-gray-100">
            <div id='calendar' class="flex-1 min-h-0"></div>
        </div>
    </main>

    <button onclick="toggleModal('modalReserva')" class="fixed bottom-6 right-6 bg-emerald-500 text-white w-14 h-14 rounded-full shadow-xl text-3xl flex items-center justify-center hover:bg-emerald-600 hover:scale-105 transition-all z-20">
        +
    </button>

    <div id="modalReserva" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="p-5 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h2 class="text-lg font-bold text-gray-800">Añadir Reserva Manual</h2>
                <button onclick="toggleModal('modalReserva')" class="text-gray-400 hover:text-gray-600 text-2xl font-bold transition">&times;</button>
            </div>
            
            <form action="{{ route('reservas.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Nombre del Huésped *</label>
                    <input type="text" name="nombre_huesped" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-emerald-200 focus:border-emerald-500 outline-none transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Entrada *</label>
                        <input type="date" name="fecha_entrada" required class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-emerald-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Salida *</label>
                        <input type="date" name="fecha_salida" required class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-emerald-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Habitación *</label>
                    <select name="habitacion" required class="w-full border border-gray-300 rounded-lg p-2.5 bg-white outline-none focus:border-emerald-500 transition">
                        <option value="Habitación Doble" class="text-orange-600 font-bold">⚠️ Hab. Doble (Sin asignar)</option>
                        <option value="Habitación Triple" class="text-orange-600 font-bold">⚠️ Hab. Triple (Sin asignar)</option>
                        <option value="Habitación 1 (Doble)">Habitación 1 (Doble)</option>
                        <option value="Habitación 2 (Triple)">Habitación 2 (Triple)</option>
                        <option value="Habitación 6 (Doble)">Habitación 6 (Doble)</option>
                        <option value="Habitación 7 (Doble)">Habitación 7 (Doble)</option>
                        <option value="Habitación 8 (Triple)">Habitación 8 (Triple)</option>
                        <option value="Ático">Ático</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-emerald-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-emerald-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-emerald-500 transition"></textarea>
                </div>
                <button type="submit" class="w-full bg-emerald-500 text-white font-bold py-3 rounded-xl mt-4 shadow-md hover:bg-emerald-600 transition">
                    Guardar Reserva
                </button>
            </form>
        </div>
    </div>

    <div id="modalEditarReserva" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="p-5 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h2 class="text-lg font-bold text-gray-800">Editar Reserva</h2>
                <button onclick="toggleModal('modalEditarReserva')" class="text-gray-400 hover:text-gray-600 text-2xl font-bold transition">&times;</button>
            </div>
            
            <form id="formEditReserva" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Nombre del Huésped *</label>
                    <input type="text" name="nombre_huesped" id="edit_nombre_huesped" required class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Entrada *</label>
                        <input type="date" name="fecha_entrada" id="edit_fecha_entrada" required class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Salida *</label>
                        <input type="date" name="fecha_salida" id="edit_fecha_salida" required class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-blue-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Habitación *</label>
                    <select name="habitacion" id="edit_habitacion" required class="w-full border border-gray-300 rounded-lg p-2.5 bg-white outline-none focus:border-blue-500 transition">
                        <option value="Habitación Doble" class="text-orange-600 font-bold">⚠️ Hab. Doble (Sin asignar)</option>
                        <option value="Habitación Triple" class="text-orange-600 font-bold">⚠️ Hab. Triple (Sin asignar)</option>
                        <option value="Habitación 1 (Doble)">Habitación 1 (Doble)</option>
                        <option value="Habitación 2 (Triple)">Habitación 2 (Triple)</option>
                        <option value="Habitación 6 (Doble)">Habitación 6 (Doble)</option>
                        <option value="Habitación 7 (Doble)">Habitación 7 (Doble)</option>
                        <option value="Habitación 8 (Triple)">Habitación 8 (Triple)</option>
                        <option value="Ático">Ático</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" id="edit_precio" class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" id="edit_telefono" class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-blue-500 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Observaciones</label>
                    <textarea name="observaciones" id="edit_observaciones" rows="2" class="w-full border border-gray-300 rounded-lg p-2.5 outline-none focus:border-blue-500 transition"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl mt-4 shadow-md hover:bg-blue-700 transition">
                    Actualizar Reserva
                </button>
            </form>
        </div>
    </div>

    <div id="modalImprimir" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm">
            <div class="p-5 border-b flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">Imprimir Semana</h2>
                <button onclick="toggleModal('modalImprimir')" class="text-gray-400 hover:text-gray-600 text-2xl font-bold transition">&times;</button>
            </div>
            <form action="{{ route('reservas.pdf') }}" method="GET" target="_blank" class="p-5 space-y-4" onsubmit="toggleModal('modalImprimir')">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-gray-700">Selecciona cualquier día de la semana:</label>
                    <input type="date" name="fecha" required value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg p-3 text-lg font-bold text-center outline-none focus:border-gray-800 transition">
                </div>
                <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl mt-4 shadow-md hover:bg-gray-800 transition">
                    Generar PDF
                </button>
            </form>
        </div>
    </div>

    <form id="formBorrarReserva" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        var reservaGlobalSeleccionada = null;

        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
        }

        function prepararEdicion() {
            Swal.close();
            var props = reservaGlobalSeleccionada.extendedProps;
            
            document.getElementById('formEditReserva').action = '/reservas/' + reservaGlobalSeleccionada.id;
            document.getElementById('edit_nombre_huesped').value = props.huesped;
            document.getElementById('edit_fecha_entrada').value = props.raw_start;
            document.getElementById('edit_fecha_salida').value = props.raw_end;
            document.getElementById('edit_habitacion').value = props.habitacion;
            document.getElementById('edit_precio').value = props.precio || '';
            document.getElementById('edit_telefono').value = props.telefono || '';
            document.getElementById('edit_observaciones').value = props.observaciones || '';
            
            toggleModal('modalEditarReserva');
        }

        function confirmarBorrado() {
            Swal.fire({
                title: '¿Eliminar Reserva?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'rounded-lg',
                    cancelButton: 'rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.getElementById('formBorrarReserva');
                    form.action = '/reservas/' + reservaGlobalSeleccionada.id;
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventosLocales = {!! json_encode($eventos) !!};

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'dayGridWeek' : 'dayGridMonth',
                locale: 'es',
                firstDay: 1,
                height: '100%',
                // NUEVO: Activamos la edición interactiva del calendario
                editable: true, 
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,today'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana'
                },
                events: eventosLocales,
                eventClick: function(info) {
                    reservaGlobalSeleccionada = info.event;
                    var props = info.event.extendedProps;
                    
                    var contenidoHTML = `
                        <div class="swal-reserva-info">
                            <p><strong>🚪 Habitación:</strong> ${props.habitacion}</p>
                            <p><strong>👤 Huésped:</strong> ${props.huesped}</p>
                            <p><strong>📅 Fechas:</strong> Del ${info.event.start.toLocaleDateString('es-ES')} al ${(info.event.end ? info.event.end.toLocaleDateString('es-ES') : info.event.start.toLocaleDateString('es-ES'))}</p>
                            <p><strong>💶 Precio:</strong> ${props.precio ? props.precio + ' €' : '-'}</p>
                            <hr class="my-3 border-gray-200">
                            <p><strong>📞 Teléfono:</strong> ${props.telefono ? props.telefono : '-'}</p>
                            <p><strong>📝 Observ.:</strong> ${props.observaciones ? props.observaciones : '-'}</p>
                            
                            <div class="mt-6 flex justify-end gap-3">
                                <button onclick="confirmarBorrado()" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-red-100 transition">🗑️ Borrar</button>
                                <button onclick="prepararEdicion()" class="bg-blue-50 text-blue-700 border border-blue-200 px-4 py-2 rounded-xl text-sm font-bold shadow-sm hover:bg-blue-100 transition">✏️ Editar</button>
                            </div>
                        </div>
                    `;

                    Swal.fire({
                        title: 'Detalles de Reserva',
                        html: contenidoHTML,
                        showConfirmButton: false,
                        showCloseButton: true,
                        customClass: { popup: 'rounded-2xl' }
                    });
                },
                // NUEVO: Captura el evento cuando se arrastra y se suelta en otro día
                eventDrop: function(info) {
                    const id = info.event.id;
                    
                    // Formateador local para evitar desfases de zona horaria (UTC)
                    const formatLocal = (date) => {
                        const d = new Date(date);
                        const year = d.getFullYear();
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const day = String(d.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    };

                    const startStr = formatLocal(info.event.start);
                    // FullCalendar maneja la fecha de salida como exclusiva. Si no tiene end, dura 1 día.
                    const endStr = info.event.end ? formatLocal(info.event.end) : startStr;

                    // Enviamos el cambio a Laravel de fondo sin recargar
                    fetch(`/reservas/${id}/mover`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            fecha_entrada: startStr,
                            fecha_salida: endStr
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                toast: true, position: 'top-end', icon: 'success',
                                title: 'Reserva movida correctamente',
                                showConfirmButton: false, timer: 2000,
                                customClass: { popup: 'rounded-xl shadow-lg' }
                            });
                        } else {
                            info.revert(); // Revierte el movimiento visual si Laravel da error
                            Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo guardar el cambio' });
                        }
                    })
                    .catch(error => {
                        info.revert(); // Revierte si se cae la conexión
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Error de conexión con el servidor' });
                    });
                }
            });
            calendar.render();

            @if(session('success'))
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false, timer: 3000,
                    customClass: { popup: 'rounded-xl shadow-lg' }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    toast: true, position: 'top-end', icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false, timer: 3000,
                    customClass: { popup: 'rounded-xl shadow-lg' }
                });
            @endif
        });
    </script>
</body>
</html>