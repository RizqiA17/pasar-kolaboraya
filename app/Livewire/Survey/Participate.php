<?php

namespace App\Livewire\Survey;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Livewire\Component;

class Participate extends Component
{
    public $survey;
    public $currentStep = 1;
    public $totalSteps = 3;

    // Kategori Koneksi
    public $jumlah_koneksi = '';
    public $jumlah_koneksi_alasan = '';
    public $rata_kualitas_koneksi = '';
    public $rata_kualitas_koneksi_alasan = '';
    public $keluasan_jejaring = '';
    public $keluasan_jejaring_alasan = '';

    // Kategori Kolaborasi
    public $kualitas_kolaborasi = '';
    public $kualitas_kolaborasi_alasan = '';
    public $keragaman_kolaborator = '';
    public $keragaman_kolaborator_alasan = '';
    public $jumlah_proyek_kolaborasi = '';
    public $jumlah_proyek_kolaborasi_alasan = '';
    public $tingkat_kolaborasi = '';
    public $tingkat_kolaborasi_alasan = '';
    public $sumber_daya_disumbangkan = [];
    public $sumber_daya_disumbangkan_alasan = '';

    // Kategori Aksi
    public $jumlah_aksi_besar = '';
    public $jumlah_aksi_besar_alasan = '';
    public $jumlah_aksi_sedang = '';
    public $jumlah_aksi_sedang_alasan = '';
    public $jumlah_aksi_kecil = '';
    public $jumlah_aksi_kecil_alasan = '';

    public function mount()
    {
        $this->survey = Survey::active()->first();

        if (!$this->survey) {
            session()->flash('error', 'Tidak ada survey yang aktif saat ini');
            return redirect()->route('dashboard');
        }

        // Check if user already responded
        if (auth()->user() && auth()->user()->hasRespondedToSurvey($this->survey->id)) {
            session()->flash('info', 'Anda sudah mengisi survey ini');
            return redirect()->route('dashboard');
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
        // if ($this->currentStep === ($this->totalSteps)) {
        //     dd([
        //         'totalSteps' => $this->currentStep,
        //         'jumlah_koneksi' => $this->jumlah_koneksi,
        //         'jumlah_koneksi_alasan' => $this->jumlah_koneksi_alasan,
        //         'rata_kualitas_koneksi' => $this->rata_kualitas_koneksi,
        //         'rata_kualitas_koneksi_alasan' => $this->rata_kualitas_koneksi_alasan,
        //         'keluasan_jejaring' => $this->keluasan_jejaring,
        //         'keluasan_jejaring_alasan' => $this->keluasan_jejaring_alasan,
        //         // Kategori Kolaborasi
        //         'kualitas_kolaborasi' => $this->kualitas_kolaborasi,
        //         'kualitas_kolaborasi_alasan' => $this->kualitas_kolaborasi_alasan,
        //         'keragaman_kolaborator' => $this->keragaman_kolaborator,
        //         'keragaman_kolaborator_alasan' => $this->keragaman_kolaborator_alasan,
        //         'jumlah_proyek_kolaborasi' => $this->jumlah_proyek_kolaborasi,
        //         'jumlah_proyek_kolaborasi_alasan' => $this->jumlah_proyek_kolaborasi_alasan,
        //         'tingkat_kolaborasi' => $this->tingkat_kolaborasi,
        //         'tingkat_kolaborasi_alasan' => $this->tingkat_kolaborasi_alasan,
        //         'sumber_daya_disumbangkan' => $this->sumber_daya_disumbangkan,
        //         'sumber_daya_disumbangkan_alasan' => $this->sumber_daya_disumbangkan_alasan,
        //         // Kategori Aksi
        //         'jumlah_aksi_besar' => $this->jumlah_aksi_besar,
        //         'jumlah_aksi_besar_alasan' => $this->jumlah_aksi_besar_alasan,
        //         'jumlah_aksi_sedang' => $this->jumlah_aksi_sedang,
        //         'jumlah_aksi_sedang_alasan' => $this->jumlah_aksi_sedang_alasan,
        //         'jumlah_aksi_kecil' => $this->jumlah_aksi_kecil,
        //         'jumlah_aksi_kecil_alasan' => $this->jumlah_aksi_kecil_alasan,
        //     ]);
        // }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        $rules = [];

        if ($this->currentStep == 1) {
            $rules = [
                'jumlah_koneksi' => 'required|integer|min:0',
                'rata_kualitas_koneksi' => 'required|integer|min:1|max:5',
                'keluasan_jejaring' => 'required|integer|min:1|max:5',
            ];
        } elseif ($this->currentStep == 2) {
            $rules = [
                'kualitas_kolaborasi' => 'required|integer|min:1|max:5',
                'keragaman_kolaborator' => 'required|integer|min:0',
                'jumlah_proyek_kolaborasi' => 'required|integer|min:0',
                'tingkat_kolaborasi' => 'required|integer|min:1|max:5',
                'sumber_daya_disumbangkan' => 'required|array|min:1',
            ];
        } elseif ($this->currentStep == 3) {
            $rules = [
                'jumlah_aksi_besar' => 'required|integer|min:0',
                'jumlah_aksi_sedang' => 'required|integer|min:0',
                'jumlah_aksi_kecil' => 'required|integer|min:0',
            ];
        }

        $this->validate($rules);
    }

    public function submit()
    {
        $this->validateCurrentStep();

        SurveyResponse::create([
            'survey_id' => $this->survey->id,
            'user_id' => auth()->user()->id,
            // Kategori Koneksi
            'jumlah_koneksi' => $this->jumlah_koneksi,
            'jumlah_koneksi_alasan' => $this->jumlah_koneksi_alasan,
            'rata_kualitas_koneksi' => $this->rata_kualitas_koneksi,
            'rata_kualitas_koneksi_alasan' => $this->rata_kualitas_koneksi_alasan,
            'keluasan_jejaring' => $this->keluasan_jejaring,
            'keluasan_jejaring_alasan' => $this->keluasan_jejaring_alasan,
            // Kategori Kolaborasi
            'kualitas_kolaborasi' => $this->kualitas_kolaborasi,
            'kualitas_kolaborasi_alasan' => $this->kualitas_kolaborasi_alasan,
            'keragaman_kolaborator' => $this->keragaman_kolaborator,
            'keragaman_kolaborator_alasan' => $this->keragaman_kolaborator_alasan,
            'jumlah_proyek_kolaborasi' => $this->jumlah_proyek_kolaborasi,
            'jumlah_proyek_kolaborasi_alasan' => $this->jumlah_proyek_kolaborasi_alasan,
            'tingkat_kolaborasi' => $this->tingkat_kolaborasi,
            'tingkat_kolaborasi_alasan' => $this->tingkat_kolaborasi_alasan,
            'sumber_daya_disumbangkan' => $this->sumber_daya_disumbangkan,
            'sumber_daya_disumbangkan_alasan' => $this->sumber_daya_disumbangkan_alasan,
            // Kategori Aksi
            'jumlah_aksi_besar' => $this->jumlah_aksi_besar,
            'jumlah_aksi_besar_alasan' => $this->jumlah_aksi_besar_alasan,
            'jumlah_aksi_sedang' => $this->jumlah_aksi_sedang,
            'jumlah_aksi_sedang_alasan' => $this->jumlah_aksi_sedang_alasan,
            'jumlah_aksi_kecil' => $this->jumlah_aksi_kecil,
            'jumlah_aksi_kecil_alasan' => $this->jumlah_aksi_kecil_alasan,
        ]);

        session()->flash('success', 'Terima kasih! Respon survey Anda telah berhasil disimpan.');
        return redirect()->route('dashboard');
    }

    public function getSumberDayaOptions()
    {
        return [
            'dana' => 'Dana',
            'keahlian' => 'Keahlian',
            'infrastruktur' => 'Infrastruktur',
            'akses_pasar' => 'Akses Pasar',
            'relasi' => 'Relasi',
            'teknologi' => 'Teknologi',
        ];
    }

    public function render()
    {
        return view('livewire.survey.participate', [
            'sumberDayaOptions' => $this->getSumberDayaOptions()
        ]);
    }
}
