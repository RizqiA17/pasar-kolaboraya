@if (session('success'))
    <div class="fixed top-4 right-4 z-50 animate-fade-in-down">
        <div class="bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg border border-green-400 flex items-center space-x-3">
            <svg class="w-6 h-6 text-green-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-100 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="fixed top-4 right-4 z-50 animate-fade-in-down">
        <div class="bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg border border-red-400 flex items-center space-x-3">
            <svg class="w-6 h-6 text-red-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-100 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="fixed top-4 right-4 z-50 animate-fade-in-down">
        <div class="bg-yellow-500 text-white px-6 py-3 rounded-xl shadow-lg border border-yellow-400 flex items-center space-x-3">
            <svg class="w-6 h-6 text-yellow-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <span class="font-medium">{{ session('warning') }}</span>
            <button onclick="this.parentElement.remove()" class="text-yellow-100 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

@if (session('info'))
    <div class="fixed top-4 right-4 z-50 animate-fade-in-down">
        <div class="bg-blue-500 text-white px-6 py-3 rounded-xl shadow-lg border border-blue-400 flex items-center space-x-3">
            <svg class="w-6 h-6 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('info') }}</span>
            <button onclick="this.parentElement.remove()" class="text-blue-100 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
@endif

<style>
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-down {
        animation: fade-in-down 0.3s ease-out;
    }
</style>

<script>
    // Auto-hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.querySelectorAll('[class*="fixed top-4 right-4"]');
        
        flashMessages.forEach(function(message) {
            setTimeout(function() {
                if (message && message.parentElement) {
                    message.remove();
                }
            }, 5000);
        });
    });
</script>
