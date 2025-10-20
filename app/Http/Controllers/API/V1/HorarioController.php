<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HorarioController extends Controller
{
    /**
     * Muestra todos los horarios.
     *
     * GET /api/v1/schedules
     */
    public function index(Request $request)
    {
        // Permite filtrar por lottery_id opcionalmente (?lottery_id=1)
        // Permite filtrar por hora opcionalmente (?time=12:00)
        $lotteryId = $request->query('lottery_id');
        $time = $request->query('time');

        $query = Horario::with('loteria');

        if ($lotteryId) {
            $query->where('lottery_id', $lotteryId);
        }

        if ($time) {
            $query->porHora($time);
        }

        $horarios = $query->orderBy('time')->get();

        return response()->json([
            'success' => true,
            'data' => $horarios,
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
     * Crea un nuevo horario.
     *
     * POST /api/v1/schedules
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'time' => 'required|string|date_format:H:i|unique:schedules,time,NULL,id,lottery_id,' . $request->lottery_id,
                'lottery_id' => 'required|exists:lotteries,id',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error interno. ' . $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        $horario = Horario::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Horario creado exitosamente.',
            'data' => $horario->load('loteria'),
        ], Response::HTTP_CREATED);
    }

    /**
     * Muestra un horario específico.
     *
     * GET /api/v1/schedules/{id}
     */
    public function show(Horario $horario)
    {
        return response()->json([
            'success' => true,
            'data' => $horario->load('loteria'),
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        //
    }

    /**
     * Actualiza un horario existente.
     *
     * PUT/PATCH /api/v1/schedules/{id}
     */
    public function update(Request $request, Horario $horario)
    {
        $validated = $request->validate([
            'time' => 'sometimes|date_format:H:i|unique:schedules,time,' . $horario->id . ',id,lottery_id,' . ($request->lottery_id ?: $horario->lottery_id),
            'lottery_id' => 'sometimes|exists:lotteries,id',
        ]);

        $horario->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Horario actualizado correctamente.',
            'data' => $horario->load('loteria'),
        ], Response::HTTP_OK);
    }

    /**
     * Elimina (soft delete) un horario.
     *
     * DELETE /api/v1/schedules/{id}
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Horario eliminado correctamente.',
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Restaura un horario eliminado.
     *
     * POST /api/v1/schedules/{id}/restore
     */
    public function restore($id)
    {
        $horario = Horario::onlyTrashed()->findOrFail($id);
        $horario->restore();

        return response()->json([
            'success' => true,
            'message' => 'Horario restaurado exitosamente.',
            'data' => $horario->load('loteria'),
        ], Response::HTTP_OK);
    }
}
