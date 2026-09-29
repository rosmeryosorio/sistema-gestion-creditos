@extends('layouts.app')

@section('title', 'Detalle de Crédito')
@section('page_header', 'Información del Crédito')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex justify-between items-center pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-xl font-bold text-slate-800">
                    {{ $credito->cliente ? $credito->cliente->nombres . ' ' . $credito->cliente->apellidos : 'Sin cliente' }}
                </h3>
                <p class="text-sm text-slate-500">Documento: {{ $credito->cliente->documento_identidad ?? 'N/A' }}</p>
            </div>
            <a href="{{ route('creditos.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-200 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Volver
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-2">
            <div>
                <span class="block text-xs uppercase text-slate-400 font-medium">Monto</span>
                <span class="text-lg font-bold text-emerald-600">${{ number_format($credito->monto, 2) }}</span>
            </div>
            <div>
                <span class="block text-xs uppercase text-slate-400 font-medium">Interés</span>
                <span class="text-lg font-semibold text-slate-700">{{ $credito->tasa_interes }}%</span>
            </div>
            <div>
                <span class="block text-xs uppercase text-slate-400 font-medium">Plazo</span>
                <span class="text-lg font-semibold text-slate-700">{{ $credito->plazo_meses }} meses</span>
            </div>
            <div>
                <span class="block text-xs uppercase text-slate-400 font-medium">Estado</span>
                <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full border bg-emerald-100 text-emerald-800 border-emerald-200">
                    {{ ucfirst($credito->estado) }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection