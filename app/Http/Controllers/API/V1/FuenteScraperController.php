<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\FuenteScraper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FuenteScraperController extends Controller
{
    /**
     * Muestra todas las fuentes de scraping.
     *
     * GET /api/v1/scraping-sources
     */
    public function index(Request $request)
    {
        // Permite filtrar por validación (?is_valid=true/false)
        // Permite filtrar por procesamiento (?processed=true/false)
        // Permite filtrar por nombre (?name=texto)
        // Permite filtrar por fechas (?start_date=2024-01-01&end_date=2024-12-31)
        $isValid = $request->query('is_valid');
        $processed = $request->query('processed');
        $name = $request->query('name');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = FuenteScraper::with('resultados');

        if ($isValid !== null) {
            $query->where('is_valid', $isValid === 'true');
        }

        if ($processed !== null) {
            if ($processed === 'true') {
                $query->procesadas();
            } else {
                $query->noProcesadas();
            }
        }

        if ($name) {
            $query->porNombre($name);
        }

        if ($startDate && $endDate) {
            $query->entreFechas($startDate, $endDate);
        }

        $fuentes = $query->orderBy('source_name')->get();

        return response()->json([
            'success' => true,
            'data' => $fuentes,
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Crea una nueva fuente de scraping.
     *
     * POST /api/v1/scraping-sources
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'source_name' => 'required|string|max:255|unique:scraping_sources,source_name',
            'source_url' => 'required|url|max:255',
            'script' => 'required|string|max:255',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_valid' => 'boolean',
        ]);

        $fuente = FuenteScraper::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fuente de scraping creada exitosamente.',
            'data' => $fuente->load('resultados'),
        ], Response::HTTP_CREATED);
    }

    /**
     * Muestra una fuente de scraping específica.
     *
     * GET /api/v1/scraping-sources/{id}
     */
    public function show(FuenteScraper $fuenteScraper)
    {
        return response()->json([
            'success' => true,
            'data' => $fuenteScraper->load('resultados'),
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuenteScraper $fuenteScraper)
    {
        //
    }

    /**
     * Actualiza una fuente de scraping existente.
     *
     * PUT/PATCH /api/v1/scraping-sources/{id}
     */
    public function update(Request $request, FuenteScraper $fuenteScraper)
    {
        $validated = $request->validate([
            'source_name' => 'sometimes|string|max:255|unique:scraping_sources,source_name,' . $fuenteScraper->id,
            'source_url' => 'sometimes|url|max:255',
            'script' => 'sometimes|string|max:255',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'processed_at' => 'nullable|date',
            'is_valid' => 'sometimes|boolean',
        ]);

        $fuenteScraper->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fuente de scraping actualizada correctamente.',
            'data' => $fuenteScraper->load('resultados'),
        ], Response::HTTP_OK);
    }

    /**
     * Elimina (soft delete) una fuente de scraping.
     *
     * DELETE /api/v1/scraping-sources/{id}
     */
    public function destroy(FuenteScraper $fuenteScraper)
    {
        $fuenteScraper->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fuente de scraping eliminada correctamente.',
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Restaura una fuente de scraping eliminada.
     *
     * POST /api/v1/scraping-sources/{id}/restore
     */
    public function restore($id)
    {
        $fuente = FuenteScraper::onlyTrashed()->findOrFail($id);
        $fuente->restore();

        return response()->json([
            'success' => true,
            'message' => 'Fuente de scraping restaurada exitosamente.',
            'data' => $fuente->load('resultados'),
        ], Response::HTTP_OK);
    }
}
