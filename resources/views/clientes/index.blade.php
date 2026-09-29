@extends('layouts.app')

@section('title', 'Clientes')
@section('page_header', 'Gestión de Clientes')

@section('content')
<div class="space-y-6">

    <!-- Alertas de éxito -->
    @if(session('success'))
        <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Encabezado y Buscador -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('clientes.index') }}" class="flex items-center gap-2 w-full sm:w-auto flex-1 max-w-md">
            <div class="relative w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Buscar por nombre, apellido o documento..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-900 transition">
                Buscar
            </button>
        </form>

        <a href="{{ route('clientes.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md flex items-center gap-2 transition w-full sm:w-auto justify-center">
            <i class="fa-solid fa-plus"></i> Nuevo Cliente
        </a>
    </div>

    <!-- Tabla de Clientes -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Doc. Identidad</th>
                        <th class="px-6 py-4">Contacto</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($clientes as $cliente)
                    <tr class="hover:bg-slate-50 transition">
                        
                        <!-- 1. Columna: CLIENTE -->
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">{{ $cliente->nombres }} {{ $cliente->apellidos }}</div>
                            <div class="text-xs text-slate-400">{{ $cliente->direccion ?? 'Sin dirección' }}</div>
                        </td>

                        <!-- 2. Columna: DOC. IDENTIDAD -->
                        <td class="px-6 py-4 font-mono text-slate-600">
                            {{ $cliente->documento_identidad }}
                        </td>

                        <!-- 3. Columna: CONTACTO -->
                        <td class="px-6 py-4 space-y-0.5">
                            @if($cliente->telefono)
                                <div class="text-slate-700"><i class="fa-solid fa-phone text-xs mr-1 text-slate-400"></i>{{ $cliente->telefono }}</div>
                            @endif
                            @if($cliente->correo)
                                <div class="text-xs text-slate-400"><i class="fa-solid fa-envelope text-xs mr-1 text-slate-400"></i>{{ $cliente->correo }}</div>
                            @endif
                            @if(!$cliente->telefono && !$cliente->correo)
                                <span class="text-xs text-slate-400">Sin contacto</span>
                            @endif
                        </td>

                        <!-- 4. Columna: ESTADO -->
                        <td class="px-6 py-4">
                            @if($cliente->estado == 1 || $cliente->estado == 'activo')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full border border-emerald-200">Activo</span>
                            @else
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-800 text-xs font-semibold rounded-full border border-rose-200">Inactivo</span>
                            @endif
                        </td>

                        <!-- 5. Columna: ACCIONES -->
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('clientes.show', $cliente->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ver">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Editar">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-slate-400">No se encontraron clientes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($clientes, 'links'))
            <div class="p-4 border-t border-slate-100">
                {{ $clientes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection