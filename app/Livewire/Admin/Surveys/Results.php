<?php

namespace App\Livewire\Admin\Surveys;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.admin.layout', ['title' => 'Hasil Survey'])]
class Results extends Component
{
    public $surveyId;
    public $survey;
    public $activeTab = 'overview';

    public function mount($surveyId)
    {
        $this->surveyId = $surveyId;
        $this->survey = Survey::with(['responses.user'])->findOrFail($surveyId);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getAverageScores()
    {
        return $this->survey->getAverageScores();
    }

    public function getRadarChartData()
    {
        $averages = $this->getAverageScores();
        // dd($averages);
        
        // Convert averages to radar chart format
        return [
            'koneksi' => [
                'jumlah_koneksi' => $averages['koneksi']['jumlah_koneksi'] ?? 0,
                'kualitas_koneksi' => $averages['koneksi']['rata_kualitas_koneksi'] ?? 0,
                'keluasan_jejaring' => $averages['koneksi']['keluasan_jejaring'] ?? 0,
            ],
            'kolaborasi' => [
                'kualitas_kolaborasi' => $averages['kolaborasi']['kualitas_kolaborasi'] ?? 0,
                'keragaman_kolaborator' => $averages['kolaborasi']['keragaman_kolaborator'] ?? 0,
                'jumlah_proyek' => $averages['kolaborasi']['jumlah_proyek_kolaborasi'] ?? 0,
                'tingkat_kolaborasi' => $averages['kolaborasi']['tingkat_kolaborasi'] ?? 0,
                'sumber_daya_disumbangkan' => $averages['kolaborasi']['sumber_daya_disumbangkan'] ?? 0,
            ],
            'aksi' => [
                'aksi_besar' => $averages['aksi']['jumlah_aksi_besar'] ?? 0,
                'aksi_sedang' => $averages['aksi']['jumlah_aksi_sedang'] ?? 0,
                'aksi_kecil' => $averages['aksi']['jumlah_aksi_kecil'] ?? 0,
            ]
        ];
    }

    public function getAnonymousReasons()
    {
        $responses = $this->survey->responses;
        
        $reasons = [
            'koneksi' => [
                'jumlah_koneksi' => $responses->pluck('jumlah_koneksi_alasan')->filter()->values(),
                'rata_kualitas_koneksi' => $responses->pluck('rata_kualitas_koneksi_alasan')->filter()->values(),
                'keluasan_jejaring' => $responses->pluck('keluasan_jejaring_alasan')->filter()->values(),
            ],
            'kolaborasi' => [
                'kualitas_kolaborasi' => $responses->pluck('kualitas_kolaborasi_alasan')->filter()->values(),
                'keragaman_kolaborator' => $responses->pluck('keragaman_kolaborator_alasan')->filter()->values(),
                'jumlah_proyek_kolaborasi' => $responses->pluck('jumlah_proyek_kolaborasi_alasan')->filter()->values(),
                'tingkat_kolaborasi' => $responses->pluck('tingkat_kolaborasi_alasan')->filter()->values(),
                'sumber_daya_disumbangkan' => $responses->pluck('sumber_daya_disumbangkan_alasan')->filter()->values(),
            ],
            'aksi' => [
                'jumlah_aksi_besar' => $responses->pluck('jumlah_aksi_besar_alasan')->filter()->values(),
                'jumlah_aksi_sedang' => $responses->pluck('jumlah_aksi_sedang_alasan')->filter()->values(),
                'jumlah_aksi_kecil' => $responses->pluck('jumlah_aksi_kecil_alasan')->filter()->values(),
            ]
        ];

        return $reasons;
    }

    public function render()
    {
        $averageScores = $this->getAverageScores();
        $radarData = $this->getRadarChartData();
        $anonymousReasons = $this->getAnonymousReasons();
        $totalResponses = $this->survey->responses->count();

        return view('livewire.admin.surveys.results', compact(
            'averageScores', 
            'radarData', 
            'anonymousReasons', 
            'totalResponses'
        ));
    }
}
