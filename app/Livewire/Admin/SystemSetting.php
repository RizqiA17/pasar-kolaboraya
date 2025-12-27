<?php

namespace App\Livewire\Admin;

use App\Models\SystemSetting as SystemSettingModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Pengaturan Sistem'])]
class SystemSetting extends Component
{
    public array $settings = [];

    public function mount()
    {
        $this->settings = SystemSettingModel::pluck('value', 'key')
            ->map(fn($v) => (bool) $v)
            ->toArray();
    }

    public function updatedSettings($value, $key)
    {
        SystemSettingModel::setValue($key, $value ? '1' : '0');
    }

    public function render()
    {
        return view('livewire.admin.system-setting');
    }
}
