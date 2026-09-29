@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Registrar Nuevo Pago</h1>
        <a href="{{ route('pagos.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
            ← Volver
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-slate-100 p-6">
        <form action="{{ route('pagos.store') }}" method="POST">
            @csrf

            <!-- Selección de Crédito / Cliente -->
            <div class="mb-4">
                <label for="credito_id" class="block text-sm font-medium text-slate-700 mb-1">
                    Seleccionar Crédito / Cliente *
                </label>
                <select name="credito_id" id="credito_id" required 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    <option value="">-- Seleccione un crédito activo --</option>
                    @foreach ($creditos as $c)
                        <option value="{{ $c->id }}" {{ old('credito_id') == $c->id ? 'selected' : '' }}>
                            Crédito #{{ $c->id }} - {{ $c->cliente->nombres ?? 'Sin nombre' }} {{ $c->cliente->apellidos ?? '' }} (Saldo pendiente: ${{ number_format($c->saldo, 2) }})
                        </option>
                    @endforeach
                </select>
                @error('credito_id')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Monto -->
            <div class="mb-4">
                <label for="monto" class="block text-sm font-medium text-slate-700 mb-1">
                    Monto a Pagado ($) *
                </label>
                <input type="number" step="0.01" min="0.01" name="monto" id="monto" value="{{ old('monto') }}" required
                       placeholder="0.00"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                @error('monto')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fecha de Pago -->
            <div class="mb-4">
                <label for="fecha_pago" class="block text-sm font-medium text-slate-700 mb-1">
                    Fecha de Pago *
                </label>
                <input type="date" name="fecha_pago" id="fecha_pago" value="{{ old('fecha_pago', date('Y-m-d')) }}" required
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                @error('fecha_pago')
                    <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Método de Pago -->
            <div class="mb-4">
                <label for="metodo_pago" class="block text-sm font-medium text-slate-700 mb-1">
                    Método de Pago
                </label>
                <select name="metodo_pago" id="metodo_pago" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    <option value="efectivo" {{ old('metodo_pago') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'selected' : '' }}>Transferencia Bancaria</option>
                    <option value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                </select>
            </div>

            <!-- Observaciones -->
            <div class="mb-6">
                <label for="observaciones" class="block text-sm font-medium text-slate-700 mb-1">
                    Observaciones (Opcional)
                </label>
                <textarea name="observaciones" id="observaciones" rows="3"
                          placeholder="Notas adicionales..."
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">{{ old('observaciones') }}</textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('pagos.index') }}" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                    Guardar Pago
                </button>
            </div>
        </form>
    </div>
</div>
@endsection