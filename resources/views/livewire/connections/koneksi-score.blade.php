<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            📊 Pilar I - Koneksi Score
        </h3>
        <button wire:click="refresh" 
                class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 
                       {{ $isLoading ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $isLoading ? 'disabled' : '' }}>
            {{ $isLoading ? 'Memuat...' : 'Refresh' }}
        </button>
    </div>

    <!-- Main Score Display -->
    <div class="text-center mb-6">
        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
            {{ $koneksiData['koneksi_score'] ?? 0 }}%
        </div>
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Skor Koneksi Keseluruhan
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
            Terakhir diperbarui: {{ $lastUpdated }}
        </div>
    </div>

    <!-- Score Breakdown Grid -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <!-- Friendship Density -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                    🔗 Friendship Density
                </span>
                <span class="text-lg font-bold text-blue-800 dark:text-blue-200">
                    {{ $koneksiData['friendship_density_score'] ?? 0 }}%
                </span>
            </div>
            <div class="w-full bg-blue-200 dark:bg-blue-700 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full transition-all duration-1000" 
                     style="width: {{ $koneksiData['friendship_density_score'] ?? 0 }}%"></div>
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                {{ $koneksiData['details']['accepted_connections'] ?? 0 }} dari {{ $koneksiData['details']['possible_pairs'] ?? 0 }} kemungkinan
            </div>
        </div>

        <!-- Average Friends per User -->
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">
                    👥 Average Friends per User
                </span>
                <span class="text-lg font-bold text-purple-800 dark:text-purple-200">
                    {{ $koneksiData['avg_friends_score'] ?? 0 }}%
                </span>
            </div>
            <div class="w-full bg-purple-200 dark:bg-purple-700 rounded-full h-2">
                <div class="bg-purple-500 h-2 rounded-full transition-all duration-1000" 
                     style="width: {{ $koneksiData['avg_friends_score'] ?? 0 }}%"></div>
            </div>
            <div class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                Rata-rata {{ $koneksiData['details']['avg_degree'] ?? 0 }} teman per user
            </div>
        </div>

        <!-- Connection Acceptance Rate -->
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-green-700 dark:text-green-300">
                    ✅ Connection Acceptance Rate
                </span>
                <span class="text-lg font-bold text-green-800 dark:text-green-200">
                    {{ $koneksiData['acceptance_rate_score'] ?? 0 }}%
                </span>
            </div>
            <div class="w-full bg-green-200 dark:bg-green-700 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" 
                     style="width: {{ $koneksiData['acceptance_rate_score'] ?? 0 }}%"></div>
            </div>
            <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                {{ $koneksiData['details']['accepted_count'] ?? 0 }} diterima dari {{ ($koneksiData['details']['accepted_count'] ?? 0) + ($koneksiData['details']['rejected_count'] ?? 0) }} total
            </div>
        </div>

        <!-- Connection Recency -->
        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-orange-700 dark:text-orange-300">
                    🕒 Connection Recency
                </span>
                <span class="text-lg font-bold text-orange-800 dark:text-orange-200">
                    {{ $koneksiData['recency_score'] ?? 0 }}%
                </span>
            </div>
            <div class="w-full bg-orange-200 dark:bg-orange-700 rounded-full h-2">
                <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" 
                     style="width: {{ $koneksiData['recency_score'] ?? 0 }}%"></div>
            </div>
            <div class="text-xs text-orange-600 dark:text-orange-400 mt-1">
                {{ $koneksiData['details']['recent_connections'] ?? 0 }} koneksi dalam 90 hari
            </div>
        </div>
    </div>

    <!-- Network Diversity -->
    <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-teal-700 dark:text-teal-300">
                🌐 Network Diversity
            </span>
            <span class="text-lg font-bold text-teal-800 dark:text-teal-200">
                {{ $koneksiData['diversity_score'] ?? 0 }}%
            </span>
        </div>
        <div class="w-full bg-teal-200 dark:bg-teal-700 rounded-full h-2">
            <div class="bg-teal-500 h-2 rounded-full transition-all duration-1000" 
                 style="width: {{ $koneksiData['diversity_score'] ?? 0 }}%"></div>
        </div>
        <div class="text-xs text-teal-600 dark:text-teal-400 mt-1">
            {{ count($koneksiData['details']['role_categories'] ?? []) }} kategori role berbeda
        </div>
    </div>

    <!-- Formula Information -->
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">
            📋 Rumus Pilar I - Koneksi (Updated)
        </h4>
        <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
            <div><strong>Friendship Density:</strong> accepted_connections / possible_pairs × 100</div>
            <div><strong>Average Friends per User:</strong> (2 × accepted_connections) / n × 100</div>
            <div><strong>Connection Acceptance Rate:</strong> accepted / (accepted + rejected) × 100</div>
            <div><strong>Connection Recency:</strong> recent_connections / total_accepted × 100</div>
            <div><strong>Network Diversity:</strong> Shannon diversity index berdasarkan role user</div>
            <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-600">
                <strong>Koneksi Score:</strong> Rata-rata dari kelima komponen di atas
            </div>
        </div>
    </div>
</div>
