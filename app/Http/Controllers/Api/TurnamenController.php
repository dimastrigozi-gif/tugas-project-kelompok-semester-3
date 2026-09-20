<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Turnamen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TurnamenController extends Controller
{
    public function index(): JsonResponse
    {
        $turnamen = Turnamen::all();

        return response()->json([
            'message' => 'Daftar turnamen berhasil diambil',
            'data' => $turnamen,
        ], 200);
    }

    public function show(int|string $id): JsonResponse
    {
        $turnamen = Turnamen::find($id);

        if (! $turnamen) {
            return response()->json([
                'message' => 'Data turnamen tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'message' => 'Detail turnamen berhasil diambil',
            'data' => $turnamen,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nama' => 'required|string',
            'game' => 'required|string',
            'jadwal' => 'required|date',
            'biaya' => 'required|integer',
        ]);

        $turnamen = Turnamen::create([
            'nama' => $request->nama,
            'game' => $request->game,
            'jadwal' => $request->jadwal,
            'biaya' => $request->biaya,
        ]);

        return response()->json([
            'message' => 'Data turnamen berhasil ditambahkan',
            'data' => $turnamen,
        ], 201);
    }
}