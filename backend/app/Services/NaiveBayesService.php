<?php

namespace App\Services;

class NaiveBayesService
{
    /**
     * Daftar gejala yang digunakan sebagai fitur klasifikasi.
     */
    public array $symptoms = [
        'demam',
        'pusing',
        'mual',
        'muntah',
        'nyeri_perut',
        'ruam_kulit',
        'nyeri_sendi',
        'lemas',
        'nafsu_makan_turun',
        'nyeri_ulu_hati',
        'batuk',
        'pilek',
        'sakit_tenggorokan',
        'diare',
        'mimisan',
    ];

    public array $diseaseLabels = [
        'flu'   => 'Flu / Influenza',
        'dbd'   => 'Demam Berdarah Dengue (DBD)',
        'tipes' => 'Tipes (Demam Tifoid)',
        'maag'  => 'Maag (Gastritis)',
    ];

    /**
     * Dataset training (data rekam gejala pasien per penyakit).
     * 1 = gejala muncul, 0 = gejala tidak muncul.
     * Data ini disusun berdasarkan pola gejala umum tiap penyakit
     * untuk keperluan tugas klasifikasi Naive Bayes.
     */
    public function dataset(): array
    {
        return [
            'flu' => [
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 0, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 0, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 1, 'pilek' => 1, 'sakit_tenggorokan' => 1, 'diare' => 0, 'mimisan' => 0],
            ],
            'dbd' => [
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 1],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 1],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 1],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 1],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 1],
                ['demam' => 1, 'pusing' => 0, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 1, 'nyeri_sendi' => 1, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 1],
            ],
            'tipes' => [
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 1, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 1, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 1, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 1, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 0, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 1, 'mimisan' => 0],
                ['demam' => 1, 'pusing' => 1, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 0, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
            ],
            'maag' => [
                ['demam' => 0, 'pusing' => 0, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 0, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 0, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 1, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 0, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 0, 'mual' => 0, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 1, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 1, 'mual' => 1, 'muntah' => 0, 'nyeri_perut' => 0, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 0, 'mual' => 1, 'muntah' => 1, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 0, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
                ['demam' => 0, 'pusing' => 0, 'mual' => 0, 'muntah' => 0, 'nyeri_perut' => 1, 'ruam_kulit' => 0, 'nyeri_sendi' => 0, 'lemas' => 0, 'nafsu_makan_turun' => 1, 'nyeri_ulu_hati' => 1, 'batuk' => 0, 'pilek' => 0, 'sakit_tenggorokan' => 0, 'diare' => 0, 'mimisan' => 0],
            ],
        ];
    }

    /**
     * Hitung probabilitas P(symptom=1|disease) dan P(disease) dari dataset,
     * menggunakan Laplace smoothing agar tidak ada probabilitas 0.
     */
    protected function buildModel(): array
    {
        $dataset = $this->dataset();
        $totalRecords = 0;
        foreach ($dataset as $records) {
            $totalRecords += count($records);
        }

        $model = [];
        foreach ($dataset as $disease => $records) {
            $n = count($records);
            $prior = $n / $totalRecords;

            $probSymptom = [];
            foreach ($this->symptoms as $symptom) {
                $count = 0;
                foreach ($records as $record) {
                    $count += $record[$symptom];
                }
                // Laplace smoothing: (count + 1) / (n + 2)
                $probSymptom[$symptom] = ($count + 1) / ($n + 2);
            }

            $model[$disease] = [
                'prior' => $prior,
                'prob_symptom' => $probSymptom,
                'n' => $n,
            ];
        }

        return $model;
    }

    /**
     * Klasifikasikan gejala pasien menggunakan Naive Bayes (Bernoulli).
     *
     * @param array $selectedSymptoms daftar key gejala yang dipilih pasien
     * @return array hasil diagnosis terurut dari probabilitas tertinggi
     */
    public function classify(array $selectedSymptoms): array
    {
        $model = $this->buildModel();
        $results = [];

        foreach ($model as $disease => $info) {
            // gunakan log-probability supaya tidak underflow
            $logProb = log($info['prior']);

            foreach ($this->symptoms as $symptom) {
                $p = $info['prob_symptom'][$symptom];
                if (in_array($symptom, $selectedSymptoms, true)) {
                    $logProb += log($p);
                } else {
                    $logProb += log(1 - $p);
                }
            }

            $results[$disease] = $logProb;
        }

        // Normalisasi log-probability jadi persentase menggunakan softmax
        $maxLog = max($results);
        $expSum = 0;
        $expValues = [];
        foreach ($results as $disease => $logProb) {
            $expValues[$disease] = exp($logProb - $maxLog);
            $expSum += $expValues[$disease];
        }

        $final = [];
        foreach ($expValues as $disease => $expVal) {
            $final[] = [
                'disease' => $disease,
                'label' => $this->diseaseLabels[$disease],
                'probability' => round(($expVal / $expSum) * 100, 2),
            ];
        }

        usort($final, fn ($a, $b) => $b['probability'] <=> $a['probability']);

        return $final;
    }
}
