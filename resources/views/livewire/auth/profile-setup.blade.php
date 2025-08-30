<div class="flex flex-col gap-6">
    <x-auth-header :title="'Lengkapi Profil Anda'" :description="'Bantu kami mengenal Anda lebih baik untuk pengalaman yang lebih personal'" />

    <!-- Progress Bar -->
    <div class="w-full">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Langkah {{ $currentStep }} dari {{ $totalSteps }}</span>
            <span class="text-sm font-medium text-gray-700">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%">
            </div>
        </div>
    </div>

    <!-- Step Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        @if ($currentStep === 1)
            <!-- Step 1: Basic Information -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Dasar</h3>
                    <p class="text-sm text-gray-600">Berikan informasi dasar tentang diri Anda</p>
                </div>

                <flux:input wire:model="organization" :label="'Organisasi/Perusahaan'" type="text"
                    :placeholder="'Nama organisasi atau perusahaan Anda'" />

                <flux:field>
                    <flux:label>Nomor Telepon</flux:label>

                    <flux:input.group>
                        <flux:input.group.prefix>+62</flux:input.group.prefix>

                        <flux:input wire:model="phone" type="tel" placeholder="812-3456-7890" />
                    </flux:input.group>

                    <flux:error name="phone" />
                </flux:field>

                <flux:textarea wire:model="vision" rows="2" :label="'Visi/Misi'" :placeholder="'Ceritakan visi dan misi Anda'"  />
            </div>
        @elseif($currentStep === 2)
            <!-- Step 2: Social Media -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Media Sosial</h3>
                    <p class="text-sm text-gray-600">Bagikan link media sosial Anda (opsional)</p>
                </div>

                <flux:input wire:model="socialMedia.linkedin" :label="'LinkedIn'" type="url"
                    :placeholder="'https://linkedin.com/in/username'" />

                <flux:input wire:model="socialMedia.twitter" :label="'Twitter/X'" type="url"
                    :placeholder="'https://twitter.com/username'" />

                <flux:input wire:model="socialMedia.instagram" :label="'Instagram'" type="url"
                    :placeholder="'https://instagram.com/username'" />

                <flux:input wire:model="socialMedia.facebook" :label="'Facebook'" type="url"
                    :placeholder="'https://facebook.com/username'" />

                <flux:input wire:model="socialMedia.website" :label="'Website Pribadi'" type="url"
                    :placeholder="'https://website.com'" />
            </div>
        @elseif($currentStep === 3)
            <!-- Step 3: Skills -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 mb-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Keahlian</h3>
                    <p class="text-sm text-gray-600">Pilih keahlian yang Anda miliki</p>
                </div>

                <div class="space-y-4">
                    @foreach ($skills as $skill)
                        <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                            <input type="checkbox" id="skill_{{ $skill->id }}" wire:model="selectedSkills"
                                value="{{ $skill->id }}"
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="skill_{{ $skill->id }}" class="flex-1 text-sm font-medium text-gray-700">
                                {{ $skill->name }}
                            </label>

                            @if (in_array($skill->id, $selectedSkills))
                                <div class="flex items-center space-x-2">
                                    <select wire:model="skillLevels.{{ $skill->id }}"
                                        class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="beginner">Pemula</option>
                                        <option value="intermediate">Menengah</option>
                                        <option value="advanced">Lanjutan</option>
                                        <option value="expert">Ahli</option>
                                    </select>

                                    <label class="flex items-center space-x-1">
                                        <input type="checkbox" wire:model="primarySkills" value="{{ $skill->id }}"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-xs text-gray-600">Utama</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($currentStep === 4)
            <!-- Step 4: Interests & Contributions -->
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 mb-4">
                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Minat & Kontribusi</h3>
                    <p class="text-sm text-gray-600">Pilih minat dan kontribusi Anda</p>
                </div>

                <!-- Interests -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-3">Minat</h4>
                    <div class="space-y-3">
                        @foreach ($interests as $interest)
                            <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                                <input type="checkbox" id="interest_{{ $interest->id }}"
                                    wire:model="selectedInterests" value="{{ $interest->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="interest_{{ $interest->id }}"
                                    class="flex-1 text-sm font-medium text-gray-700">
                                    {{ $interest->name }}
                                </label>

                                @if (in_array($interest->id, $selectedInterests))
                                    <select wire:model="interestLevels.{{ $interest->id }}"
                                        class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <option value="low">Rendah</option>
                                        <option value="medium">Sedang</option>
                                        <option value="high">Tinggi</option>
                                    </select>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Contributions -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-3">Kontribusi</h4>
                    <div class="space-y-3">
                        @foreach ($contributions as $contribution)
                            <div class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg">
                                <input type="checkbox" id="contribution_{{ $contribution->id }}"
                                    wire:model="selectedContributions" value="{{ $contribution->id }}"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="contribution_{{ $contribution->id }}"
                                    class="flex-1 text-sm font-medium text-gray-700">
                                    {{ $contribution->name }}
                                </label>

                                @if (in_array($contribution->id, $selectedContributions))
                                    <div class="flex flex-col space-y-2">
                                        <input type="text"
                                            wire:model="contributionDescriptions.{{ $contribution->id }}"
                                            placeholder="Deskripsi kontribusi"
                                            class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                        <input type="date" wire:model="contributionDates.{{ $contribution->id }}"
                                            class="text-xs border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
            <div>
                @if ($currentStep > 1)
                    <flux:button wire:click="previousStep" variant="subtle" icon="chevron-left">
                        Sebelumnya
                    </flux:button>
                @endif
            </div>

            <div class="flex items-center space-x-3">
                @if ($currentStep < $totalSteps)
                    <flux:button wire:click="skipStep" variant="subtle">
                        Skip
                    </flux:button>

                    <flux:button wire:click="nextStep" variant="primary" icon:trailing="chevron-right">
                        Selanjutnya
                    </flux:button>
                @else
                    <flux:button wire:click="saveProfile" variant="primary" class="w-full sm:w-auto" icon:trailing="chevron-right">
                        Selesai & Lanjutkan
                    </flux:button>
                @endif
            </div>
        </div>
    </div>

    <!-- Completion Percentage -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Kelengkapan Profil</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Profil Anda sudah <strong>{{ $completionPercentage }}%</strong> lengkap</p>
                </div>
            </div>
        </div>
    </div>
</div>



