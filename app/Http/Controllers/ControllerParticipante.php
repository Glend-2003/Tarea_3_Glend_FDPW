<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ControllerParticipante extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Participante::all();
        return view('participantes.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('participantes.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación con correo único
        $validated = $request->validate([
            'nombre_participante' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo_electronico' => 'required|email|unique:participante,correo_electronico',
            'ponente' => 'required|boolean'
        ], [
            'correo_electronico.unique' => 'El correo electrónico ya está registrado.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'Debe ingresar un correo válido.',
            'nombre_participante.required' => 'El nombre es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'ponente.required' => 'Debe seleccionar el tipo de participación.'
        ]);

        Participante::create($validated);

        return redirect()->route('participantes.index')
                        ->with('success', 'Participante registrado exitosamente.');
    }

   
  

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Participante::find($id);
        return $item;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Participante::find($id);
        return view('participantes.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
    {
        $item = Participante::findOrFail($id);

        // Validación con correo único excepto el actual
        $validated = $request->validate([
            'nombre_participante' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo_electronico' => [
                'required',
                'email',
                Rule::unique('participante', 'correo_electronico')->ignore($item->id)
            ],
            'ponente' => 'required|boolean'
        ], [
            'correo_electronico.unique' => 'El correo electrónico ya está registrado por otro participante.',
            'correo_electronico.required' => 'El correo electrónico es obligatorio.',
            'correo_electronico.email' => 'Debe ingresar un correo válido.',
            'nombre_participante.required' => 'El nombre es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'ponente.required' => 'Debe seleccionar el tipo de participación.'
        ]);

        $item->update($validated);

        return redirect()->route('participantes.index')
                        ->with('success', 'Participante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Participante::destroy($id);
            return redirect()->route('participantes.index')
                            ->with('success', 'Participante eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('participantes.index')
                            ->with('error', 'Error al eliminar el participante.');
        }
    }
}
