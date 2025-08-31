@props(['white' => false])
<div class="flex justify-center text-start text-sm lg:w-[14rem]">
    @if($white)
    <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025-white.webp') }}" alt="Logo" class="h-10 lg:-translate-x-4">
    @else
    <img src="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}" alt="Logo" class="h-10 lg:-translate-x-4">
    @endif
</div>
