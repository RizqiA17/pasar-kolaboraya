@php
    $collaborationsEnabled = \App\Models\SystemSetting::isCollaborationsEnabled();
    $isSuperAdmin = auth()->user()->isSuperAdmin();
    $isFormDisabled = !$collaborationsEnabled && !$isSuperAdmin;
@endphp

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-6 relative">
    <!-- SVG Accent Elements -->
    <x-svg-accent position="top-left" size="w-20 h-20" opacity="opacity-10" />
    <x-svg-accent position="center-right" size="w-16 h-16" opacity="opacity-10" />
    <x-svg-accent position="bottom-left" size="w-14 h-14" opacity="opacity-10" />
    
    <div class="max-w-2xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 dark:from-blue-400 dark:to-purple-500 flex items-center justify-center shadow-lg dark:shadow-slate-900/50">
                <svg class="w-10 h-10 text-white dark:text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-slate-100 mb-2">Buat Kolaborasi Baru</h2>
            <p class="text-gray-600 dark:text-slate-400 text-lg">Mari ciptakan sesuatu yang luar biasa bersama-sama</p>
        </div>

        <!-- Friend Info Card -->
        @if ($friend_id)
            <div class="mb-8 p-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg text-white relative">
                <!-- SVG Accent for Friend Info Card -->
                <x-svg-accent position="top-right" size="w-8 h-8" opacity="opacity-20" />
                
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold backdrop-blur-sm">
                        {{ substr($this->friendName, 0, 2) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">Kolaborasi dengan</h3>
                        <p class="text-blue-100 text-lg">{{ $this->friendName }}</p>
                    </div>
                    <div class="ml-auto">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Feature Disabled Message -->
        @if($isFormDisabled)
            <div class="mb-6 p-6 bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-800 mb-2">
                            Fitur Kolaborasi Dinonaktifkan
                        </h3>
                        <p class="text-red-700 mb-4">
                            Fitur kolaborasi sedang dinonaktifkan oleh administrator. Silakan hubungi administrator untuk informasi lebih lanjut.
                        </p>
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg text-white">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-gradient-to-r from-red-500 to-pink-600 rounded-xl shadow-lg text-white">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Main Form -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl dark:shadow-slate-900/50 border border-gray-100 dark:border-slate-700 p-8 relative {{ $isFormDisabled ? 'opacity-60 pointer-events-none' : '' }}">
            <!-- SVG Accent for Form -->
            <x-svg-accent position="top-right" size="w-10 h-10" opacity="opacity-5" />
            
            @if($isFormDisabled)
                <!-- Disabled Overlay -->
                <div class="absolute inset-0 bg-gray-100/80 dark:bg-slate-900/80 rounded-2xl flex items-center justify-center z-10">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-2">Form Dinonaktifkan</h3>
                        <p class="text-gray-500 dark:text-slate-400 text-sm">Fitur kolaborasi sedang dinonaktifkan</p>
                    </div>
                </div>
            @endif
            
            <form wire:submit.prevent="create" class="space-y-6">
                <!-- Title Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        Judul Kolaborasi
                    </label>
                    <input 
                        type="text" 
                        wire:model="title" 
                        placeholder="Masukkan judul kolaborasi yang menarik dan inspiratif..."
                        class="w-full px-4 py-4 border-2 border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/30 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 text-lg @error('title') border-red-300 focus:ring-red-100 focus:border-red-500 @enderror"
                    >
                    @error('title')
                        <div class="flex items-center gap-2 text-red-500 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        Deskripsi Kolaborasi
                    </label>
                    <textarea 
                        wire:model="description" 
                        placeholder="Jelaskan detail kolaborasi, tujuan, dan hasil yang ingin dicapai..."
                        rows="5"
                        class="w-full px-4 py-4 border-2 border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 rounded-xl focus:ring-4 focus:ring-purple-100 dark:focus:ring-purple-900/30 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-200 text-lg resize-none @error('description') border-red-300 focus:ring-red-100 focus:border-red-500 @enderror"
                    ></textarea>
                    @error('description')
                        <div class="flex items-center gap-2 text-red-500 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-100 dark:border-slate-700">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button 
                            type="submit" 
                            @if($isFormDisabled) disabled @endif
                            class="flex-1 font-semibold py-4 px-8 rounded-xl shadow-lg dark:shadow-slate-900/50 transition-all duration-200 flex items-center justify-center gap-3 {{ $isFormDisabled ? 'bg-gray-400 dark:bg-slate-600 text-gray-200 cursor-not-allowed' : 'cursor-pointer bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-500 dark:to-purple-500 hover:from-blue-700 hover:to-purple-700 dark:hover:from-blue-600 dark:hover:to-purple-600 text-white hover:shadow-xl dark:hover:shadow-slate-900/50 transform hover:-translate-y-0.5' }}"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ $isFormDisabled ? 'Fitur Dinonaktifkan' : 'Buat Kolaborasi' }}
                        </button>
{{--                         
                        <button 
                            type="button" x-on:click="$flux.modal('confirm').close()"
                            class="px-8 py-4 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-3"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </button> --}}
                    </div>
                </div>
            </form>
        </div>

        <!-- Inspiration Section -->
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-2 text-gray-500 dark:text-slate-400 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Kolaborasi adalah kunci untuk menciptakan dampak yang lebih besar</span>
            </div>
        </div>
    </div>
</div>
