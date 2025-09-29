<div id="ecosystem-detail-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-neutral-green px-6 py-4 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold">Detail Ekosistem</h3>
                <button id="close-ecosystem-modal" class="text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <!-- General Information -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-slate-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Umum
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ecosystem Name -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Nama
                            Ekosistem</label>
                        <p id="ecosystem-name" class="text-gray-900 dark:text-slate-100 font-medium"></p>
                    </div>

                    <!-- Organization -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Organisasi</label>
                        <p id="ecosystem-organization" class="text-gray-900 dark:text-slate-100"></p>
                    </div>

                    <!-- Issues Addressed -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Isu yang
                            Diperjuangkan</label>
                        <div id="ecosystem-issues" class="flex flex-wrap gap-2">
                            <!-- Issues will be populated here -->
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg md:col-span-2">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Deskripsi</label>
                        <p id="ecosystem-description" class="text-gray-900 dark:text-slate-100 leading-relaxed"></p>
                    </div>

                    <!-- Work Region -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Wilayah
                            Kerja</label>
                        <p id="ecosystem-work-region" class="text-gray-900 dark:text-slate-100"></p>
                    </div>

                    <!-- Member Count -->
                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Jumlah
                            Anggota</label>
                        <p id="ecosystem-member-count" class="text-gray-900 dark:text-slate-100 font-medium"></p>
                    </div>
                </div>
            </div>

            <!-- Roles Information -->
            <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-slate-100 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Peran dalam Ekosistem
                </h4>

                <!-- Existing Roles -->
                <div class="mb-6">
                    <h5 class="text-md font-medium text-gray-700 dark:text-slate-300 mb-3 flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        Peran yang Sudah Ada
                    </h5>
                    <div id="existing-roles" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Existing roles will be populated here -->
                    </div>
                </div>

                <!-- Needed Roles -->
                <div>
                    <h5 class="text-md font-medium text-gray-700 dark:text-slate-300 mb-3 flex items-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                        Peran yang Dibutuhkan
                    </h5>
                    <div id="needed-roles" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Needed roles will be populated here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 dark:bg-slate-700 px-6 py-4 flex justify-end space-x-3">
            <button id="close-ecosystem-modal-btn"
                class="px-4 py-2 text-gray-600 dark:text-slate-300 bg-gray-200 dark:bg-slate-600 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-500 transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('ecosystem-detail-modal');
        const closeBtn = document.getElementById('close-ecosystem-modal');
        const closeBtnFooter = document.getElementById('close-ecosystem-modal-btn');

        // Close modal functions
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        closeBtn.addEventListener('click', closeModal);
        closeBtnFooter.addEventListener('click', closeModal);

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Function to show ecosystem details
        window.showEcosystemDetails = function(ecosystemData) {
            // Populate general information
            document.getElementById('ecosystem-name').textContent = ecosystemData.ecosystem.name || 'N/A';
            document.getElementById('ecosystem-organization').textContent = ecosystemData.ecosystem
                .organization || 'N/A';
            document.getElementById('ecosystem-description').textContent = ecosystemData.ecosystem
                .description || 'Tidak ada deskripsi tersedia';
            document.getElementById('ecosystem-work-region').textContent = ecosystemData.ecosystem
                .work_region || 'N/A';
            document.getElementById('ecosystem-member-count').textContent = ecosystemData.totalUsers || 0;

            // Populate issues
            const issuesContainer = document.getElementById('ecosystem-issues');
            issuesContainer.innerHTML = '';
            if (ecosystemData.ecosystem.issues && ecosystemData.ecosystem.issues.length > 0) {
                ecosystemData.ecosystem.issues.forEach(issue => {
                    const issueTag = document.createElement('span');
                    issueTag.className =
                        'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300';
                    issueTag.textContent = issue;
                    issuesContainer.appendChild(issueTag);
                });
            } else {
                const noIssues = document.createElement('span');
                noIssues.className = 'text-gray-500 dark:text-gray-400 italic';
                noIssues.textContent = 'Tidak ada isu yang didefinisikan';
                issuesContainer.appendChild(noIssues);
            }

            // Populate existing roles
            const existingRolesContainer = document.getElementById('existing-roles');
            existingRolesContainer.innerHTML = '';
            if (ecosystemData.roles && ecosystemData.roles.length > 0) {
                ecosystemData.roles.forEach(role => {
                    const roleCard = document.createElement('div');
                    roleCard.className =
                        'bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg p-4 shadow-sm dark:shadow-slate-900/30';
                    roleCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="font-medium text-gray-900 dark:text-slate-100 ">${role.role}</h6>
                        <span class="text-sm text-gray-500 dark:text-slate-400">${role.count} orang</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300">asdsadsdasdadsa ${role.description || 'Tidak ada deskripsi tersedia'}</p>
                `;
                    existingRolesContainer.appendChild(roleCard);
                });
            } else {
                const noRoles = document.createElement('div');
                noRoles.className = 'col-span-2 text-center text-gray-500 dark:text-gray-400 italic py-8';
                noRoles.textContent = 'Belum ada peran yang terdefinisi';
                existingRolesContainer.appendChild(noRoles);
            }

            // Populate needed roles
            const neededRolesContainer = document.getElementById('needed-roles');
            neededRolesContainer.innerHTML = '';
            if (ecosystemData.needed_roles && ecosystemData.needed_roles.length > 0) {
                ecosystemData.needed_roles.forEach(role => {
                    const roleCard = document.createElement('div');
                    roleCard.className =
                        'bg-orange-50 dark:bg-slate-800 border border-orange-200 dark:border-slate-700 rounded-lg p-4 shadow-sm dark:shadow-slate-900/30';
                    roleCard.innerHTML = `
                    <div class="flex items-center justify-between mb-2 ">
                        <h6 class="font-medium text-gray-900 dark:text-slate-100">${role}</h6>
                        <span class="text-sm text-orange-600 dark:text-orange-300 font-medium">Dibutuhkan</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-300">Peran ini masih dibutuhkan dalam ekosistem</p>
                `;
                    neededRolesContainer.appendChild(roleCard);
                });
            } else {
                const noNeededRoles = document.createElement('div');
                noNeededRoles.className =
                    'col-span-2 text-center text-gray-500 dark:text-gray-400 italic py-8';
                noNeededRoles.textContent = 'Semua peran sudah terpenuhi';
                neededRolesContainer.appendChild(noNeededRoles);
            }

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };
    });
</script>
