<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Credito;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoController extends Controller
{
    /**
     * Muestra la lista de pagos registrados.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $pagos = Pago::with(['credito.cliente'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('credito.cliente', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo pago.
     */
    public function create()
    {
        // Solo recuperamos créditos con saldo pendiente mayor a 0
        $creditos = Credito::with('cliente')
            ->where('saldo', '>', 0)
            ->get();

        return view('pagos.create', compact('creditos'));
    }

    /**
     * Almacena un nuevo pago, validando que no exceda el saldo y descontándolo.
     */
    public function store(Request $request)
{
    $request->validate([
        'credito_id' => 'required|exists:creditos,id',
        'monto'      => 'required|numeric|min:0.01',
        'fecha_pago' => 'required|date',
    ]);

    $credito = Credito::findOrFail($request->credito_id);

    if ($request->monto > $credito->saldo) {
        return back()
            ->withErrors([
                'monto' => 'El monto del pago no puede ser mayor al saldo pendiente del crédito.'
            ])
            ->withInput();
    }

    $pago = Pago::create([
        'credito_id'    => $request->credito_id,
        'monto'         => $request->monto,
        'fecha_pago'    => $request->fecha_pago,
        'metodo_pago'   => $request->metodo_pago ?? 'Efectivo',
        'observaciones' => $request->observaciones ?? null,
    ]);

    $credito->saldo = $credito->saldo - $request->monto;

    if ($credito->saldo <= 0) {
        $credito->saldo = 0;
        $credito->estado = 'pagado';
    }

    $credito->save();

    return redirect()->route('pagos.index')
                     ->with('pago_exitoso', true)
                     ->with('pago_id', $pago->id);
}
    public function show($id)
    {
        $pago = Pago::with(['credito.cliente'])->findOrFail($id);
        return view('pagos.show', compact('pago'));
    }

    /**
     * Elimina un pago registrado y devuleve el monto al saldo del crédito.
     */
    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        
        // Restaurar el monto devuelto al crédito
        $credito = Credito::find($pago->credito_id);
        if ($credito) {
            $credito->saldo += $pago->monto;
            
            // Si el crédito estaba marcado como pagado, reactivarlo
            if ($credito->estado === 'pagado') {
                $credito->estado = 'activo';
            }
            
            $credito->save();
        }

        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
    public function registrarPago(Request $request, $id)
{
    // ... Tu lógica para procesar el pago ...

    // Redireccionamos enviando la variable 'pago_exitoso' y el ID del crédito
    return redirect()->route('creditos.index')
                 ->with('pago_exitoso', true)
                 ->with('credito_id', $request->credito_id ?? $request->id);
}
public function comprobante($id)
{
    $pago = Pago::with('credito.cliente')->findOrFail($id);

    $pdf = Pdf::loadView('pagos.comprobante', compact('pago'));

    return $pdf->download('comprobante-pago-' . $pago->id . '.pdf');

}
}