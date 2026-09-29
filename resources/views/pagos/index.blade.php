@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Gestión de Pagos</h1>

        <a href="{{ route('pagos.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors">
            + Registrar Pago
        </a>
    </div>

    <!-- Alertas -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tarjeta Principal -->
    <div class="bg-white rounded-xl shadow-md border border-slate-100 p-6">

        <!-- Buscador -->
        <form method="GET"
              action="{{ route('pagos.index') }}"
              class="mb-6 flex gap-3">

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Buscar por nombre de cliente..."
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none text-slate-700">

            <button type="submit"
                    class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white font-medium rounded-lg transition-colors">
                Buscar
            </button>

        </form>

        <!-- Tabla de Pagos -->
        <div class="overflow-x-auto rounded-lg border border-slate-200">

            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase font-semibold tracking-wider">

                        <th class="py-3.5 px-4">ID</th>
                        <th class="py-3.5 px-4">Cliente</th>
                        <th class="py-3.5 px-4">Monto Pagado</th>
                        <th class="py-3.5 px-4">Fecha de Pago</th>
                        <th class="py-3.5 px-4">Método</th>
                        <th class="py-3.5 px-4 text-center">Acciones</th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">

                    @forelse ($pagos as $pago)

                        <tr class="hover:bg-slate-50 transition-colors">

                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                #{{ $pago->id }}
                            </td>

                            <td class="py-3.5 px-4 font-medium">
                                {{ $pago->credito->cliente->nombres ?? 'N/A' }}
                                {{ $pago->credito->cliente->apellidos ?? '' }}
                            </td>

                            <td class="py-3.5 px-4 font-bold text-emerald-600">
                                ${{ number_format($pago->monto, 2) }}
                            </td>

                            <td class="py-3.5 px-4">
                                {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold">
                                    {{ ucfirst($pago->metodo_pago ?? 'Efectivo') }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-center">

                                <form action="{{ route('pagos.destroy', $pago->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Deseas eliminar este pago? El monto volverá al saldo del crédito.');"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-rose-600 hover:text-rose-800 font-semibold transition-colors">
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6"
                                class="py-8 text-center text-slate-400">
                                No se encontraron pagos registrados.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Paginación -->
        @if($pagos->hasPages())
            <div class="mt-5">
                {{ $pagos->links() }}
            </div>
        @endif

    </div>

</div>


{{-- ========================================================= --}}
{{-- MODAL DE PAGO EXITOSO                                     --}}
{{-- ========================================================= --}}

@if(session('pago_exitoso'))

    <div id="pagoModal" class="modal-overlay">

        <div class="modal-pago">

            <!-- Botón cerrar -->
            <button type="button"
                    class="modal-close"
                    onclick="cerrarModal()">
                &times;
            </button>

            <!-- Icono -->
            <div class="modal-icon">
                ✓
            </div>

            <!-- Título -->
            <h2>¡Pago registrado!</h2>

            <!-- Mensaje -->
            <p>
                El pago del crédito se registró correctamente.
            </p>

            <!-- Botones -->
            <div class="modal-actions">

                <a href="{{ route('pagos.comprobante', session('pago_id')) }}"
                   target="_blank"
                   class="btn-comprobante">
                    Descargar comprobante
                </a>

                <button type="button"
                        onclick="cerrarModal()"
                        class="btn-cerrar">
                    Cerrar
                </button>

            </div>

        </div>

    </div>

@endif


{{-- ========================================================= --}}
{{-- ESTILOS DEL MODAL                                         --}}
{{-- ========================================================= --}}

<style>

    /*
     * IMPORTANTE:
     * El modal se coloca sobre toda la pantalla.
     * No modifica la posición del header ni de la tabla.
     */

    .modal-overlay {
        position: fixed !important;

        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;

        width: 100vw !important;
        height: 100vh !important;

        background: rgba(15, 23, 42, 0.60);

        display: flex !important;

        align-items: center !important;
        justify-content: center !important;

        z-index: 999999 !important;

        margin: 0 !important;
        padding: 0 !important;
    }


    /* Ventana blanca */

    .modal-pago {
        position: relative;

        width: 420px;
        max-width: 90%;

        padding: 35px;

        background: #ffffff;

        border-radius: 15px;

        text-align: center;

        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.30);

        animation: aparecer 0.25s ease-out;
    }


    /* Botón X */

    .modal-close {
        position: absolute;

        top: 10px;
        right: 15px;

        border: none;

        background: transparent;

        color: #64748b;

        font-size: 28px;

        line-height: 1;

        cursor: pointer;
    }


    .modal-close:hover {
        color: #1e293b;
    }


    /* Icono de éxito */

    .modal-icon {
        width: 65px;
        height: 65px;

        margin: 0 auto 15px;

        border-radius: 50%;

        background: #dcfce7;

        color: #16a34a;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 32px;

        font-weight: bold;
    }


    /* Título */

    .modal-pago h2 {
        margin: 0 0 10px;

        color: #1e293b;

        font-size: 22px;

        font-weight: 700;
    }


    /* Texto */

    .modal-pago p {
        margin: 0 0 25px;

        color: #64748b;

        font-size: 14px;
    }


    /* Botones */

    .modal-actions {
        display: flex;

        justify-content: center;

        align-items: center;

        gap: 10px;
    }


    /* Descargar comprobante */

    .btn-comprobante {
        display: inline-block;

        padding: 10px 16px;

        background: #4f46e5;

        color: #ffffff;

        text-decoration: none;

        border-radius: 6px;

        font-size: 14px;

        font-weight: 600;

        transition: background 0.2s;
    }


    .btn-comprobante:hover {
        background: #4338ca;

        color: #ffffff;
    }


    /* Cerrar */

    .btn-cerrar {
        padding: 10px 16px;

        background: #f1f5f9;

        color: #334155;

        border: none;

        border-radius: 6px;

        cursor: pointer;

        font-size: 14px;
    }


    .btn-cerrar:hover {
        background: #e2e8f0;
    }


    /* Animación */

    @keyframes aparecer {

        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }

    }

</style>


{{-- ========================================================= --}}
{{-- JAVASCRIPT DEL MODAL                                     --}}
{{-- ========================================================= --}}

<script>

    function cerrarModal() {

        const modal = document.getElementById('pagoModal');

        if (modal) {
            modal.remove();
        }

    }

</script>

@endsection