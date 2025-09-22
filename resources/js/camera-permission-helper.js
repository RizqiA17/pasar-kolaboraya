/**
 * Camera Permission Helper
 * Provides standardized camera access and permission handling for QR scanners
 */

class CameraPermissionHelper {
    constructor() {
        this.isSupported = this.checkCameraSupport();
        this.permissionState = 'unknown';
    }

    /**
     * Check if camera is supported in the current browser
     */
    checkCameraSupport() {
        return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
    }

    /**
     * Check camera permission status
     */
    async checkPermissionStatus() {
        if (!this.isSupported) {
            return 'not-supported';
        }

        try {
            const permissionStatus = await navigator.permissions.query({ name: 'camera' });
            this.permissionState = permissionStatus.state;
            return permissionStatus.state;
        } catch (error) {
            console.warn('Permission API not supported, will request permission on camera access');
            return 'unknown';
        }
    }

    /**
     * Request camera permission with user-friendly error handling
     */
    async requestCameraPermission() {
        if (!this.isSupported) {
            throw new Error('Camera tidak didukung di browser ini. Silakan gunakan browser yang lebih baru atau perangkat yang mendukung kamera.');
        }

        try {
            // Check current permission status
            const permissionStatus = await this.checkPermissionStatus();
            
            if (permissionStatus === 'denied') {
                throw new Error('Izin kamera ditolak. Silakan aktifkan izin kamera di pengaturan browser dan refresh halaman.');
            }

            // Request camera access
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'environment', // Prefer back camera
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                }
            });

            return stream;
        } catch (error) {
            console.error('Camera permission error:', error);
            
            // Provide user-friendly error messages
            if (error.name === 'NotAllowedError') {
                throw new Error('Izin kamera ditolak. Silakan klik ikon kamera di address bar dan pilih "Izinkan" untuk memberikan akses kamera.');
            } else if (error.name === 'NotFoundError') {
                throw new Error('Kamera tidak ditemukan. Pastikan perangkat memiliki kamera yang berfungsi.');
            } else if (error.name === 'NotReadableError') {
                throw new Error('Kamera sedang digunakan oleh aplikasi lain. Tutup aplikasi lain yang menggunakan kamera dan coba lagi.');
            } else if (error.name === 'OverconstrainedError') {
                throw new Error('Kamera tidak mendukung resolusi yang diminta. Coba gunakan perangkat lain.');
            } else if (error.name === 'SecurityError') {
                throw new Error('Akses kamera diblokir karena alasan keamanan. Pastikan menggunakan HTTPS atau localhost.');
            } else {
                throw new Error(`Tidak dapat mengakses kamera: ${error.message}`);
            }
        }
    }

    /**
     * Show user-friendly permission instructions
     */
    showPermissionInstructions() {
        const instructions = `
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Cara Mengaktifkan Izin Kamera:</h3>
                <ol class="list-decimal list-inside text-blue-800 dark:text-blue-200 space-y-1 text-sm">
                    <li>Klik ikon kamera (📷) di address bar browser</li>
                    <li>Pilih "Izinkan" atau "Allow" untuk memberikan akses kamera</li>
                    <li>Refresh halaman jika diperlukan</li>
                    <li>Klik tombol "Mulai Scanning" lagi</li>
                </ol>
                <p class="text-xs text-blue-700 dark:text-blue-300 mt-2">
                    <strong>Catatan:</strong> Jika tidak ada ikon kamera, pastikan browser mendukung kamera dan menggunakan HTTPS.
                </p>
            </div>
        `;
        return instructions;
    }

    /**
     * Create a standardized error display
     */
    createErrorDisplay(message, showInstructions = true) {
        const errorHtml = `
            <div class="absolute inset-0 flex items-center justify-center bg-red-50 dark:bg-red-900/20 rounded-lg">
                <div class="text-center p-4">
                    <div class="text-red-500 text-4xl mb-2">📷</div>
                    <p class="text-red-600 dark:text-red-400 font-medium mb-2">${message}</p>
                    ${showInstructions ? this.showPermissionInstructions() : ''}
                </div>
            </div>
        `;
        return errorHtml;
    }

    /**
     * Create a loading display
     */
    createLoadingDisplay() {
        return `
            <div class="absolute inset-0 flex items-center justify-center bg-gray-100 dark:bg-slate-700 rounded-lg">
                <div class="text-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                    <p class="text-gray-600 dark:text-slate-300">Meminta izin kamera...</p>
                </div>
            </div>
        `;
    }
}

// Export for use in other scripts
window.CameraPermissionHelper = CameraPermissionHelper;
