@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Editar Crédito #{{ $credito->id }}</h1>
        <a href="{{ route('creditos.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
            ← Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-r shadow-sm">
            <p class="font-bold mb-1">Por favor corrige los siguientes errores:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md border border-slate-100 p-6">
        <form action="{{ route('creditos.update', $credito->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Cliente -->
            <div class="mb-4">
                <label for="cliente_id" class="block text-sm font-medium text-slate-700 mb-1">Cliente *</label>
                <select name="cliente_id" id="cliente_id" required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 bg-white">
                    <option value="">-- Seleccione un cliente --</option>
                    @foreach ($clientes as $c)
                        <option value="{{ $c->id }}" {{ old('cliente_id', $credito->cliente_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->nombres ?? $c->nombre }} {{ $c->apellidos ?? $c->apellido }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Monto Total y Saldo Pendiente -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="monto_total" class="block text-sm font-medium text-slate-700 mb-1">Monto Total ($) *</label>
                    <input type="number" step="0.01" min="0" name="monto_total" id="monto_total" 
                           value="{{ old('monto_total', $credito->monto_total ?? $credito->monto) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('monto_total')
                        <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="saldo_pendiente" class="block text-sm font-medium text-slate-700 mb-1">Saldo Pendiente ($) *</label>
                    <input type="number" step="0.01" min="0" name="saldo_pendiente" id="saldo_pendiente" 
                           value="{{ old('saldo_pendiente', $credito->saldo_pendiente ?? $credito->saldo) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('saldo_pendiente')
                        <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Tasa de Interés y Plazo en Meses -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tasa_interes" class="block text-sm font-medium text-slate-700 mb-1">Tasa de Interés (%) *</label>
                    <input type="number" step="0.01" min="0" name="tasa_interes" id="tasa_interes" 
                           value="{{ old('tasa_interes', $credito->tasa_interes) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('tasa_interes')
                        <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="plazo_meses" class="block text-sm font-medium text-slate-700 mb-1">Plazo (Meses) *</label>
                    <input type="number" min="1" name="plazo_meses" id="plazo_meses" 
                           value="{{ old('plazo_meses', $credito->plazo_meses) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('plazo_meses')
                        <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Fecha de Inicio y Estado -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Inicio *</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                           value="{{ old('fecha_inicio', \Carbon\Carbon::parse($credito->fecha_inicio)->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('fecha_inicio')
                        <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="estado" class="block text-sm font-medium text-slate-700 mb-1">Estado *</label>
                    <select name="estado" id="estado" required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 bg-white">
                        <option value="Activo" {{ old('estado', $credito->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Pendiente" {{ old('estado', $credito->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Finalizado" {{ old('estado', $credito->estado) == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                    @error('estado')
                        <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('creditos.index') }}" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection