<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditoController extends Controller
{
    /**
     * Muestra el listado de créditos.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $creditos = Credito::with('cliente')
            ->when($search, function ($query, $search) {
                return $query->whereHas('cliente', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('creditos.index', compact('creditos'));
    }

    /**
     * Muestra el formulario para crear un nuevo crédito.
     */
    public function create()
    {
        $clientes = Cliente::all();
        return view('creditos.create', compact('clientes'));
    }

    /**
     * Almacena un crédito en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'    => 'required|exists:clientes,id',
            'monto_total'   => 'required|numeric|min:0.01',
            'tasa_interes'  => 'required|numeric|min:0',
            'plazo_meses'   => 'required|integer|min:1',
            'fecha_inicio'  => 'required|date',
        ]);

        $data = $request->all();
        $data['saldo_pendiente'] = $request->monto_total;
        $data['estado'] = 'Activo';

        Credito::create($data);

        return redirect()->route('creditos.index')
                         ->with('success', 'Crédito creado con éxito.');
    }

    /**
     * Muestra el formulario para editar el crédito.
     */
    public function edit($id)
    {
        $credito = Credito::findOrFail($id);
        $clientes = Cliente::all();

        return view('creditos.edit', compact('credito', 'clientes'));
    }

    /**
     * Actualiza el crédito especificado en la base de datos.
     */
    public function update(Request $request, $id)
{
    $credito = Credito::findOrFail($id);

    // 1. Validar los datos recibidos del formulario
    $validatedData = $request->validate([
        'cliente_id'      => 'required|exists:clientes,id',
        'monto_total'     => 'required|numeric|min:0',
        'saldo_pendiente' => 'required|numeric|min:0',
        'tasa_interes'    => 'required|numeric|min:0',
        'plazo_meses'     => 'required|integer|min:1',
        'fecha_inicio'    => 'required|date',
        'estado'          => 'required|string',
    ]);

    // 2. Mapear a los nombres reales de las columnas en la base de datos
    $credito->update([
        'cliente_id'   => $request->cliente_id,
        'monto'        => $request->monto_total,     // Columna en MySQL: monto
        'saldo'        => $request->saldo_pendiente, // Columna en MySQL: saldo
        'tasa_interes' => $request->tasa_interes,
        'plazo_meses'  => $request->plazo_meses,
        'fecha_inicio' => $request->fecha_inicio,
        'estado'       => $request->estado,
    ]);

    return redirect()->route('creditos.index')
                     ->with('success', 'Crédito actualizado correctamente.');
}
    /**
     * Elimina el crédito de la base de datos.
     */
    public function destroy($id)
    {
        $credito = Credito::findOrFail($id);
        $credito->delete();

        return redirect()->route('creditos.index')
                         ->with('success', 'Crédito eliminado con éxito.');
    }
    
}