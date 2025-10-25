@props(['class' => ''])

<div class="relative {{ $class }}">
    <script>
        // Apply theme immediately when component is rendered
        (function() {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                html.classList.add('dark');
                localStorage.setItem('flux.appearance', 'dark');
            } else {
                html.classList.remove('dark');
                localStorage.setItem('flux.appearance', 'light');
            }
        })();
    </script>
    <button 
        id="dark-mode-toggle"
        type="button"
        class="relative inline-flex items-center cursor-pointer justify-center w-10 h-10 rounded-lg bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-gray-200 dark:border-slate-700 text-gray-600 dark:text-slate-300 hover:text-gray-900 dark:hover:text-slate-100 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800"
        aria-label="Toggle dark mode"
    >
        <!-- Sun icon (visible in dark mode) -->
        <svg id="sun-icon" class="w-5 h-5 hidden dark:block transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        
        <!-- Moon icon (visible in light mode) -->
        <svg id="moon-icon" class="w-5 h-5 block dark:hidden transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>
</div>

<script>
// Global dark mode functions
window.darkModeUtils = {
    applyTheme() {
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            html.classList.add('dark');
            localStorage.setItem('flux.appearance', 'dark');
        } else {
            html.classList.remove('dark');
            localStorage.setItem('flux.appearance', 'light');
        }
        
        // Dispatch custom event for theme change
        const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
        document.dispatchEvent(new CustomEvent('themeChanged', {
            detail: { theme: currentTheme }
        }));
    },

    bindToggle() {
        const toggle = document.getElementById('dark-mode-toggle');
        if (!toggle) return;

        // Remove existing listener if any
        if (toggle._darkModeListener) {
            toggle.removeEventListener('click', toggle._darkModeListener);
        }

        // Create new listener
        toggle._darkModeListener = () => {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            html.classList.toggle('dark', !isDark);
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
            localStorage.setItem('flux.appearance', isDark ? 'light' : 'dark');
            
            // Dispatch custom event for theme change
            document.dispatchEvent(new CustomEvent('themeChanged', {
                detail: { theme: isDark ? 'light' : 'dark' }
            }));
        };
        
        toggle.addEventListener('click', toggle._darkModeListener);
    },

    init() {
        this.applyTheme();
        this.bindToggle();
    }
};

// Initialize on DOM ready
function initializeDarkMode() {
    window.darkModeUtils.init();
}

// Re-initialize after Livewire navigation
document.addEventListener('livewire:navigated', function() {
    // Small delay to ensure DOM is updated
    setTimeout(() => {
        window.darkModeUtils.init();
    }, 50);
});

// Initialize on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeDarkMode);
} else {
    initializeDarkMode();
}
</script>
