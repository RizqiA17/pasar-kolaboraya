<div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

<!-- Sidebar -->
<div id="mobile-sidebar"
    class="flex lg:max-h-[100svh_-_56px] mt-14 w-64 flex-col fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
    <div
        class="flex flex-col flex-grow border-r bg-cream/80 border-white/20 dark:border-slate-700 dark:bg-slate-900/90! backdrop-blur-xl shadow-2xl shadow-blue-500/10 dark:shadow-none lg:max-h-svh max-h-[calc(100svh_-_148px)]">

        <!-- Mobile Close Button -->
        <div class="lg:hidden flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex items-center space-x-3">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-pink-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-slate-800 dark:text-slate-200">Panel Admin</h1>
            </div>
            <button type="button" id="mobile-sidebar-close"
                class="text-slate-500 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-3 sm:p-4 overflow-y-auto max-h-[calc(100svh_-_56px)] space-y-1 sm:space-y-2">

            <x-admin.sidebar-nav title="Utama">

                <x-admin.sidebar-nav-item route="admin.dashboard" icon="chart-bar-square" label="Dashboard" />

                <x-admin.sidebar-nav-item route="admin.surveys" icon="clipboard" label="Pasar Kecil" />

                <x-admin.sidebar-nav-item route="admin.pasar-kolaboraya.manage" icon="server-stack"
                    label="Pasar Kolaboraya" />

            </x-admin.sidebar-nav>

            <x-admin.sidebar-nav title="Manajemen">

                <x-admin.sidebar-nav-item route="admin.users" icon="users" label="Peserta" />
                
                <x-admin.sidebar-nav-item route="admin.connections" icon="link" label="Koneksi" />

                <x-admin.sidebar-nav-item route="admin.ecosystems" icon="user-group" label="Ekosistem" />

                <x-admin.sidebar-nav-item route="admin.collective-actions" icon="calendar" label="Aksi Kolektif" />

                <x-admin.sidebar-nav-item route="admin.registration-keys" icon="key" label="Kunci Registrasi" />

                <x-admin.sidebar-nav-item route="admin.user-approvals" icon="check-circle" label="Persetujuan User" />

            </x-admin.sidebar-nav>

            <x-admin.sidebar-nav title="Data Master">

                <x-admin.sidebar-nav-item route="admin.interests" icon="heart" label="Minat" />

                <x-admin.sidebar-nav-item route="admin.skills" icon="light-bulb" label="Keahlian" />

                <x-admin.sidebar-nav-item route="admin.peran" icon="user" label="Peran" />

            </x-admin.sidebar-nav>

            <x-admin.sidebar-nav title="Pengaturan Sistem">

                <x-admin.sidebar-nav-item route="admin.system-settings" icon="cog-6-tooth" label="Pengaturan Sistem" />

            </x-admin.sidebar-nav>

        </nav>
    </div>
</div>

<script data-navigate-once>
    function initializeMobileSidebar() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        const mobileSidebarClose = document.getElementById('mobile-sidebar-close');

        if (!mobileMenuButton || !mobileSidebar || !mobileSidebarOverlay || !mobileSidebarClose) {
            return; // Elements not found, skip initialization
        }

        function toggleMobileSidebar() {
            const isOpen = !mobileSidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                // Close sidebar
                mobileSidebar.classList.add('-translate-x-full');
                mobileSidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                // Open sidebar
                mobileSidebar.classList.remove('-translate-x-full');
                mobileSidebarOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeMobileSidebar() {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Remove existing event listeners to prevent duplicates
        const newMobileMenuButton = mobileMenuButton.cloneNode(true);
        mobileMenuButton.parentNode.replaceChild(newMobileMenuButton, mobileMenuButton);

        const newMobileSidebarClose = mobileSidebarClose.cloneNode(true);
        mobileSidebarClose.parentNode.replaceChild(newMobileSidebarClose, mobileSidebarClose);

        const newMobileSidebarOverlay = mobileSidebarOverlay.cloneNode(true);
        mobileSidebarOverlay.parentNode.replaceChild(newMobileSidebarOverlay, mobileSidebarOverlay);

        // Toggle sidebar on button click
        newMobileMenuButton.addEventListener('click', toggleMobileSidebar);

        // Close sidebar on close button click
        newMobileSidebarClose.addEventListener('click', closeMobileSidebar);

        // Close sidebar on overlay click
        newMobileSidebarOverlay.addEventListener('click', closeMobileSidebar);

        // Close sidebar when clicking on navigation links (mobile only)
        const navLinks = mobileSidebar.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) { // lg breakpoint
                    closeMobileSidebar();
                }
            });
        });
    }

    // Initialize on DOM content loaded
    document.addEventListener('DOMContentLoaded', initializeMobileSidebar);

    // Re-initialize after Livewire navigation
    document.addEventListener('livewire:navigated', initializeMobileSidebar);

    // Close sidebar on escape key (global listener)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

            if (mobileSidebar && mobileSidebarOverlay) {
                mobileSidebar.classList.add('-translate-x-full');
                mobileSidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    });

    // Handle window resize (global listener)
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

            if (mobileSidebar && mobileSidebarOverlay) {
                mobileSidebar.classList.add('-translate-x-full');
                mobileSidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }
    });
</script>
