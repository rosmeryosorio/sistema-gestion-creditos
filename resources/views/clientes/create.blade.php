@extends('layouts.app')

@section('title', 'Nuevo Cliente')
@section('page_header', 'Registrar Nuevo Cliente')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
    
    @if ($errors->any())
        <div class="mb-4 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-xl">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Nombres *</label>
                <input type="text" name="nombres" value="{{ old('nombres') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Apellidos *</label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Documento de Identidad *</label>
                <input type="text" name="documento_identidad" value="{{ old('documento_identidad') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Correo Electrónico</label>
                <input type="email" name="correo" value="{{ old('correo') }}" 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Dirección</label>
                <textarea name="direccion" rows="2" 
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('direccion') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
            <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition">Cancelar</a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 shadow-md transition">
                Guardar Cliente
            </button>
        </div>
    </form>
</div>
@endsection