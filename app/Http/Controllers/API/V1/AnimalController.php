<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnimalController extends Controller
{
    /**
     * Muestra un listado de animales.
     * 
     * @group Animales
     * @responseField id int ID del animal
     * @responseField name string Nombre del animal
     * @responseField number int Número asociado
     * @responseField color string Color del animal
     */
    public function index()
    {
        return response()->json(Animal::all());
    }

    /**
     * Muestra un animal específico.
     *
     * @urlParam id integer required ID del animal
     */
    public function show(Animal $animal)
    {
        return response()->json($animal);
    }

    /**
     * Crea un nuevo animal (uso restringido, solo inicialización).
     *
     * @bodyParam name string required
     * @bodyParam number int required
     * @bodyParam color string required
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer|unique:animals,number',
            'color' => 'required|string|max:100',
            'rulette_sector' => 'nullable|string|max:1',
        ]);

        $animal = Animal::create($data);
        return response()->json($animal, Response::HTTP_CREATED);
    }

    /**
     * Actualiza un animal existente.
     */
    public function update(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'color' => 'sometimes|string|max:100',
        ]);

        $animal->update($data);
        return response()->json($animal);
    }

    /**
     * Elimina un animal (soft delete).
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
