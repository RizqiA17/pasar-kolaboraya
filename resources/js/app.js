// Initialize dark mode on page load
document.addEventListener('DOMContentLoaded', function() {
    // Check for saved theme preference or default to light mode
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const html = document.documentElement;
    
    // Set initial theme
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        html.classList.add('dark');
        localStorage.setItem('flux.appearance', 'dark');
    } else {
        html.classList.remove('dark');
        localStorage.setItem('flux.appearance', 'light');
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        if (!localStorage.getItem('theme')) {
            if (e.matches) {
                html.classList.add('dark');
                localStorage.setItem('flux.appearance', 'dark');
            } else {
                html.classList.remove('dark');
                localStorage.setItem('flux.appearance', 'light');
            }
        }
    });
});