<span
    class="px-3 py-1 text-xs font-medium rounded-full
        @if ($status === 'active')
            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
        @elseif ($status === 'inactive')
            bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
        @else
            bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
        @endif">
    {{ $label }}
</span>
