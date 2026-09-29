@extends('layouts.app')

@section('title', 'Nuevo Crédito')
@section('page_header', 'Registrar Nuevo Crédito')

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

    <form action="{{ route('creditos.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Cliente *</label>
                <select name="cliente_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">-- Seleccionar Cliente --</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombres }} {{ $cliente->apellidos }} (Doc: {{ $cliente->documento_identidad }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Monto ($) *</label>
                <input type="number" step="0.01" name="monto" value="{{ old('monto') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="0.00">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Tasa de Interés (%) *</label>
                <input type="number" step="0.01" name="tasa_interes" value="{{ old('tasa_interes') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="5.00">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Plazo (Meses) *</label>
                <input type="number" name="plazo_meses" value="{{ old('plazo_meses') }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="12">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Fecha de Inicio *</label>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', date('Y-m-d')) }}" required 
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Estado Inicial</label>
                <select name="estado" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aprobado" {{ old('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
            <a href="{{ route('creditos.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl hover:bg-slate-200 transition">Cancelar</a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 shadow-md transition">
                Guardar Crédito
            </button>
        </div>
    </form>
</div>
@endsection