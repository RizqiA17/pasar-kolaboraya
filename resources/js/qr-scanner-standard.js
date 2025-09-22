/**
 * Standardized QR Scanner Component
 * Provides consistent QR scanning functionality across all components
 */

class QRScannerStandard {
    constructor(containerId, options = {}) {
        this.containerId = containerId;
        this.options = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0,
            facingMode: 'environment',
            ...options
        };
        
        this.html5QrcodeScanner = null;
        this.isScanning = false;
        this.cameraHelper = new CameraPermissionHelper();
        
        this.init();
    }

    init() {
        // Wait for Livewire to be ready
        if (typeof Livewire !== 'undefined') {
            document.addEventListener('livewire:init', () => {
                this.setupLivewireListeners();
            });
        } else {
            // Fallback for non-Livewire usage
            document.addEventListener('DOMContentLoaded', () => {
                this.setupEventListeners();
            });
        }
    }

    setupLivewireListeners() {
        Livewire.on('start-camera', () => {
            this.startCamera();
        });

        Livewire.on('stop-camera', () => {
            this.stopCamera();
        });
    }

    setupEventListeners() {
        // Setup for non-Livewire usage
        const startButton = document.querySelector(`[data-qr-start="${this.containerId}"]`);
        const stopButton = document.querySelector(`[data-qr-stop="${this.containerId}"]`);
        
        if (startButton) {
            startButton.addEventListener('click', () => this.startCamera());
        }
        
        if (stopButton) {
            stopButton.addEventListener('click', () => this.stopCamera());
        }
    }

    async startCamera() {
        try {
            // Show loading state
            this.showLoading();

            // Check camera support
            if (!this.cameraHelper.isSupported) {
                throw new Error('Camera tidak didukung di browser ini');
            }

            // Request camera permission
            const stream = await this.cameraHelper.requestCameraPermission();

            // Clear existing scanner
            if (this.html5QrcodeScanner) {
                this.html5QrcodeScanner.clear();
            }

            // Create new scanner
            this.html5QrcodeScanner = new Html5Qrcode(this.containerId);

            // Start camera with proper error handling
            await this.html5QrcodeScanner.start(
                { facingMode: this.options.facingMode },
                this.options,
                (decodedText, decodedResult) => {
                    console.log('QR Code detected:', decodedText);
                    this.onQRDetected(decodedText, decodedResult);
                },
                (errorMessage) => {
                    // Ignore scan errors, keep scanning
                    console.log('QR scan error:', errorMessage);
                }
            );

            this.isScanning = true;
            this.hideLoading();

        } catch (err) {
            console.error('Camera error:', err);
            this.showError(err.message);
        }
    }

    stopCamera() {
        this.isScanning = false;
        if (this.html5QrcodeScanner) {
            this.html5QrcodeScanner.stop().then(() => {
                this.html5QrcodeScanner.clear();
                this.html5QrcodeScanner = null;
            }).catch((err) => {
                console.log('Error stopping scanner:', err);
            });
        }
    }

    onQRDetected(decodedText, decodedResult) {
        // Default behavior - can be overridden
        console.log('QR Code detected:', decodedText);
        
        // Emit custom event for other components to listen
        const event = new CustomEvent('qr-detected', {
            detail: { decodedText, decodedResult }
        });
        document.dispatchEvent(event);
    }

    showLoading() {
        const container = document.getElementById(this.containerId);
        if (container) {
            container.innerHTML = this.cameraHelper.createLoadingDisplay();
        }
    }

    hideLoading() {
        // Loading will be hidden when camera starts successfully
    }

    showError(message) {
        const container = document.getElementById(this.containerId);
        if (container) {
            container.innerHTML = this.cameraHelper.createErrorDisplay(message);
        }
    }

    // Cleanup method
    destroy() {
        this.stopCamera();
    }
}

// Auto-initialize scanners on page load
document.addEventListener('DOMContentLoaded', function() {
    // Find all QR scanner containers
    const scannerContainers = document.querySelectorAll('[data-qr-scanner]');
    
    scannerContainers.forEach(container => {
        const containerId = container.id;
        if (containerId) {
            new QRScannerStandard(containerId);
        }
    });
});

// Export for use in other scripts
window.QRScannerStandard = QRScannerStandard;
