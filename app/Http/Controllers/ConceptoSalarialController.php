<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoSalarial;

class ConceptoSalarialController extends Controller
{
    public function index()
    {
        $conceptos = ConceptoSalarial::orderBy('descripcion')->get();
        return view('conceptos.index', compact('conceptos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_concepto' => 'required|in:credito,debito',
            'descripcion' => 'required|string|max:255|unique:conceptos_salariales,descripcion',
        ]);

        ConceptoSalarial::create([
            'tipo_concepto' => $request->tipo_concepto,
            'descripcion' => $request->descripcion,
            'fijo' => $request->has('fijo'),
            'afecta_ips' => $request->has('afecta_ips'),
            'afecta_aguinaldo' => $request->has('afecta_aguinaldo'),
        ]);

        return redirect()->route('conceptos.index')->with('success', 'Concepto creado correctamente.');
    }
}
