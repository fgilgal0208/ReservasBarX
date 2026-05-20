<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Bar Equis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen bg-cover bg-center bg-no-repeat flex items-center justify-center relative" style="background-image: url('{{ asset('img/barx.webp') }}');">

    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <div class="relative z-10 w-full max-w-sm bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl mx-4">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">BAR EQUIS</h1>
            <p class="text-sm text-gray-500 font-semibold mt-1">Gestión de Alojamientos</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Usuario</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                       placeholder="Ej: barx">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition shadow-sm"
                       placeholder="••••••••">
            </div>

            @error('name')
                <p class="text-red-500 text-sm font-semibold text-center">{{ $message }}</p>
            @enderror

            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-800 transition shadow-lg mt-4 text-lg">
                Entrar al Sistema
            </button>
        </form>
    </div>

</body>
</html>