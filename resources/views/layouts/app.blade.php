<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Créditos')</title>
    <!-- Tailwind CSS CDN -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans text-slate-800 min-h-screen flex flex-col">

    <!-- Navegación Superior -->
    <header class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-xl font-bold">
                <i class="fa-solid fa-wallet"></i>
                <span>CrediManager</span>
            </div>
            
<nav class="px-4 py-6 space-y-1">
    <a href="{{ route('clientes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <i class="fa-solid fa-users w-5 text-indigo-400"></i> Clientes
    </a>
    <a href="{{ route('creditos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <i class="fa-solid fa-hand-holding-dollar w-5 text-indigo-400"></i> Créditos
    </a>
    <a href="{{ route('pagos.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition">
        <i class="fa-solid fa-receipt w-5 text-indigo-400"></i> Pagos
    </a>
</nav>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 rounded shadow-sm">
                <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-rose-100 border-l-4 border-rose-500 text-rose-800 rounded shadow-sm">
                <i class="fa-solid fa-circle-xmark mr-2"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 text-center py-4 text-xs text-slate-500">
        Sistema de Gestión de Créditos &copy; {{ date('Y') }}
    </footer>

</body>
</html>