<?php

namespace App\Http\Controllers;

use App\Models\ConceptoSalarial;
use Illuminate\Http\Request;

class ConceptoSalarialController extends Controller
{
    public function create()
    {
        return view('conceptos_salariales.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
        $validated = $request->validate([
            'tipo_concepto' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fijo' => 'boolean',
            'afecta_ips' => 'boolean',
            'afecta_aguinaldo' => 'boolean',
        ]);

        ConceptoSalarial::create([
            'tipo_concepto' => $validated['tipo_concepto'],
            'descripcion' => $validated['descripcion'],
            'fijo' => $request->has('fijo'),
            'afecta_ips' => $request->has('afecta_ips'),
            'afecta_aguinaldo' => $request->has('afecta_aguinaldo'),
        ]);

        return redirect('/dashboard')->with('success', 'Concepto salarial creado correctamente.');
    }
}
