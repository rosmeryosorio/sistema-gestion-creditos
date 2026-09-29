@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Editar Cliente</h1>
        <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
            ← Volver
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-slate-100 p-6">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nombres" class="block text-sm font-medium text-slate-700 mb-1">Nombres *</label>
                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $cliente->nombres) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('nombres') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="apellidos" class="block text-sm font-medium text-slate-700 mb-1">Apellidos *</label>
                    <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" required
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('apellidos') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="dui" class="block text-sm font-medium text-slate-700 mb-1">DUI / Documento</label>
                    <input type="text" name="dui" id="dui" value="{{ old('dui', $cliente->dui ?? $cliente->documento) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('dui') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="telefono" class="block text-sm font-medium text-slate-700 mb-1">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $cliente->telefono) }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">
                    @error('telefono') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="direccion" class="block text-sm font-medium text-slate-700 mb-1">Dirección</label>
                <textarea name="direccion" id="direccion" rows="3"
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-700">{{ old('direccion', $cliente->direccion) }}</textarea>
                @error('direccion') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('clientes.index') }}" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                    Actualizar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection