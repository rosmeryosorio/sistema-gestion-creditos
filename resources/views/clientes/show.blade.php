@extends('layouts.app')

@section('title', 'Perfil de Cliente')
@section('page_header', 'Historial del Cliente')

@section('content')
<div class="space-y-6">
    <!-- Ficha del Cliente -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-indigo-100 text-indigo-600 font-bold text-2xl rounded-2xl flex items-center justify-center border border-indigo-200">
                {{ substr($cliente->nombres, 0, 1) }}{{ substr($cliente->apellidos, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $cliente->nombres }} {{ $cliente->apellidos }}</h2>
                <p class="text-sm text-slate-500">DUI/Documento: <span class="font-mono text-slate-700 font-semibold">{{ $cliente->documento_identidad }}</span></p>
            </div>
        </div>
        <div class="flex flex-wrap gap-4 text-sm">
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                <span class="block text-xs text-slate-400 uppercase font-semibold">Teléfono</span>
                <span class="font-medium text-slate-800">{{ $cliente->telefono }}</span>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                <span class="block text-xs text-slate-400 uppercase font-semibold">Correo</span>
                <span class="font-medium text-slate-800">{{ $cliente->correo }}</span>
            </div>
        </div>
    </div>

    <!-- Historial de Créditos -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Historial de Créditos Asociados</h3>
            <a href="{{ route('creditos.create', ['cliente_id' => $cliente->id]) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition">
                + Otorgar Nuevo Crédito
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 text-slate-500 font-semibold uppercase text-xs border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Fecha Otorgamiento</th>
                        <th class="px-6 py-4">Monto Inicial</th>
                        <th class="px-6 py-4">Total con Interés</th>
                        <th class="px-6 py-4">Saldo Pendiente</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cliente->creditos as $credito)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 text-slate-600">{{ $credito->fecha_otorgamiento }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800">${{ number_format($credito->monto, 2) }}</td>
                        <td class="px-6 py-4 text-slate-700">${{ number_format($credito->total_credito, 2) }}</td>
                        <td class="px-6 py-4 font-bold text-indigo-600">${{ number_format($credito->saldo, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                {{ $credito->estado == 'activo' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $credito->estado == 'pagado' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $credito->estado == 'vencido' ? 'bg-rose-100 text-rose-800' : '' }}">
                                {{ ucfirst($credito->estado) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('creditos.show', $credito->id) }}" class="text-indigo-600 font-medium hover:underline text-xs">Ver Detalle</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-slate-400">Este cliente aún no registra créditos.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection