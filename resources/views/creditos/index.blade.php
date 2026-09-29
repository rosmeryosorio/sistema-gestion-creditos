@extends('layouts.app')

@section('title', 'Créditos')
@section('page_header', 'Gestión de Créditos')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Encabezado y Buscador -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('creditos.index') }}" class="flex items-center gap-2 w-full sm:w-auto flex-1 max-w-md">
            <div class="relative w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Buscar por cliente..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
            </div>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-900 transition">
                Buscar
            </button>
        </form>

        <a href="{{ route('creditos.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md flex items-center gap-2 transition w-full sm:w-auto justify-center">
            <i class="fa-solid fa-plus"></i> Nuevo Crédito
        </a>
    </div>

    <!-- Tabla de Créditos -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Monto</th>
                        <th class="px-6 py-4">Interés</th>
                        <th class="px-6 py-4">Plazo</th>
                        <th class="px-6 py-4">Fecha Inicio</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($creditos as $credito)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-bold text-slate-900">
                            {{ $credito->cliente ? $credito->cliente->nombres . ' ' . $credito->cliente->apellidos : 'Cliente no asignado' }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-emerald-600">
                            ${{ number_format($credito->monto, 2) }}
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $credito->tasa_interes }}%
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $credito->plazo_meses }} meses
                        </td>
                        <td class="px-6 py-4 text-slate-600">
    {{ \Carbon\Carbon::parse($credito->fecha_otorgamiento ?? $credito->fecha_inicio)->format('d/m/Y') }}
</td>
                        <td class="px-6 py-4">
                            @if($credito->estado == 'aprobado' || $credito->estado == 'activo')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded-full border border-emerald-200">Aprobado</span>
                            @elseif($credito->estado == 'pendiente')
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full border border-amber-200">Pendiente</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-800 text-xs font-semibold rounded-full border border-slate-200">{{ ucfirst($credito->estado) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('creditos.show', $credito->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ver">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('creditos.edit', $credito->id) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Editar">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-slate-400">No se encontraron créditos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($creditos, 'links'))
            <div class="p-4 border-t border-slate-100">
                {{ $creditos->links() }}
            </div>
        @endif
    </div>
</div>
<!-- Carga de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('pago_exitoso'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '¡Pago Registrado!',
            text: 'El pago se procesó con éxito. ¿Deseas descargar la factura comprobante?',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Sí, descargar factura',
            cancelButtonText: 'No, después'
        }).then((result) => {
            if (result.isConfirmed) {
                var creditoId = "{{ session('credito_id') }}";
                window.open("/creditos/" + creditoId + "/factura", "_blank");
            }
        });
    });
</script>
@endif
@endsection