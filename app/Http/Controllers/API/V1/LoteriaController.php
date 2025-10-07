<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Loteria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LoteriaController extends Controller
{
    /**
     * Muestra todas las loterías (activas o inactivas).
     * 
     * GET /api/v1/lotteries
     */
    public function index(Request $request)
    {
        // Permite filtrar por estado opcionalmente (?status=active/inactive)
        $status = $request->query('status');

        $query = Loteria::query();

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $lotteries = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $lotteries,
        ], Response::HTTP_OK);
    }

    /**
     * Crea una nueva lotería.
     * 
     * POST /api/v1/lotteries
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:lotteries,name',
            'is_active' => 'boolean',
        ]);

        $loteria = Loteria::create([
            'name' => ucfirst(strtolower($validated['name'])),
            'slug' => Str::slug($validated['name']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lotería creada exitosamente.',
            'data' => $loteria,
        ], Response::HTTP_CREATED);
    }

    /**
     * Muestra una lotería específica.
     * 
     * GET /api/v1/lotteries/{id}
     */
    public function show(Loteria $lottery)
    {
        return response()->json([
            'success' => true,
            'data' => $lottery,
        ], Response::HTTP_OK);
    }

    /**
     * Actualiza una lotería existente.
     * 
     * PUT/PATCH /api/v1/lotteries/{id}
     */
    public function update(Request $request, Loteria $lottery)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:lotteries,name,' . $lottery->id,
            'is_active' => 'sometimes|boolean',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $validated['name'] = ucfirst(strtolower($validated['name']));
        }

        $lottery->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lotería actualizada correctamente.',
            'data' => $lottery,
        ], Response::HTTP_OK);
    }

    /**
     * Elimina (soft delete) una lotería.
     * 
     * DELETE /api/v1/lotteries/{id}
     */
    public function destroy(Loteria $lottery)
    {
        $lottery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lotería eliminada correctamente.',
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Restaura una lotería eliminada (opcional, si se desea usar).
     * 
     * POST /api/v1/lotteries/{id}/restore
     */
    public function restore($id)
    {
        $lottery = Loteria::onlyTrashed()->findOrFail($id);
        $lottery->restore();

        return response()->json([
            'success' => true,
            'message' => 'Lotería restaurada exitosamente.',
            'data' => $lottery,
        ], Response::HTTP_OK);
    }
}
