<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Búsqueda por nombre, apellido o documento
        $clientes = Cliente::when($search, function ($query, $search) {
            return $query->where('nombres', 'like', "%{$search}%")
                         ->orWhere('apellidos', 'like', "%{$search}%")
                         ->orWhere('documento_identidad', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres'             => 'required|string|max:255',
            'apellidos'           => 'required|string|max:255',
            'documento_identidad' => 'required|string|unique:clientes,documento_identidad',
            'telefono'            => 'nullable|string|max:20',
            'correo'              => 'nullable|email|max:255',
            'direccion'           => 'nullable|string',
            'estado'              => 'nullable|string',
        ]);

        $validated['estado'] = 1;
       

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function show($id)
    {
        $cliente = Cliente::with('creditos')->findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
{
    $cliente = Cliente::findOrFail($id);

    $request->validate([
        'nombres'   => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'telefono'  => 'nullable|string|max:20',
        'direccion' => 'nullable|string',
    ]);

    $cliente->update($request->all());

    return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito.');
}

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        // En lugar de eliminar físicamente, puedes cambiar el estado a inactivo si lo deseas:
        // $cliente->update(['estado' => 'inactivo']);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}