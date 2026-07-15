<?php

namespace App\Http\Controllers;

use App\Services\NaiveBayesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DiagnosisController extends Controller
{
    protected NaiveBayesService $naiveBayes;

    public function __construct(NaiveBayesService $naiveBayes)
    {
        $this->naiveBayes = $naiveBayes;
    }

    /**
     * GET /api/symptoms
     * Kembalikan daftar gejala yang bisa dipilih di form frontend.
     */
    public function symptoms(): JsonResponse
    {
        $labels = [
            'demam' => 'Demam',
            'pusing' => 'Pusing / Sakit Kepala',
            'mual' => 'Mual',
            'muntah' => 'Muntah',
            'nyeri_perut' => 'Nyeri Perut',
            'ruam_kulit' => 'Ruam / Bintik Merah di Kulit',
            'nyeri_sendi' => 'Nyeri Sendi / Otot',
            'lemas' => 'Badan Lemas',
            'nafsu_makan_turun' => 'Nafsu Makan Menurun',
            'nyeri_ulu_hati' => 'Nyeri Ulu Hati',
            'batuk' => 'Batuk',
            'pilek' => 'Pilek / Hidung Tersumbat',
            'sakit_tenggorokan' => 'Sakit Tenggorokan',
            'diare' => 'Diare',
            'mimisan' => 'Mimisan',
        ];

        $data = [];
        foreach ($labels as $key => $label) {
            $data[] = ['key' => $key, 'label' => $label];
        }

        return response()->json(['symptoms' => $data]);
    }

    /**
     * POST /api/diagnose
     * Body: { "symptoms": ["demam", "pusing", ...] }
     */
    public function diagnose(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'string',
        ]);

        $result = $this->naiveBayes->classify($validated['symptoms']);

        return response()->json([
            'input_symptoms' => $validated['symptoms'],
            'result' => $result,
            'top_diagnosis' => $result[0],
        ]);
    }
}
