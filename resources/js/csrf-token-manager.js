/**
 * CSRF Token Manager for Livewire
 * Prevents "page expired" errors by automatically refreshing CSRF tokens
 */

class CsrfTokenManager {
    constructor() {
        this.tokenRefreshInterval = null;
        this.lastTokenRefresh = Date.now();
        this.init();
    }

    init() {
        // Check if user is authenticated (has CSRF token)
        if (this.hasCsrfToken()) {
            this.startTokenRefresh();
            this.setupEventListeners();
        }
    }

    hasCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]') !== null;
    }

    getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : null;
    }

    startTokenRefresh() {
        // Refresh token every 15 minutes (900000 ms)
        this.tokenRefreshInterval = setInterval(() => {
            this.refreshToken();
        }, 900000);
    }

    async refreshToken() {
        try {
            const response = await fetch('/csrf-token-refresh', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': this.getCsrfToken()
                }
            });

            if (response.ok) {
                const data = await response.json();
                if (data.token) {
                    // Update meta tag
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if (meta) {
                        meta.setAttribute('content', data.token);
                    }

                    // Update Livewire CSRF token
                    if (window.Livewire) {
                        window.Livewire.find(document.body).csrf = data.token;
                    }

                    this.lastTokenRefresh = Date.now();
                    console.log('CSRF token refreshed successfully');
                }
            }
        } catch (error) {
            console.error('Failed to refresh CSRF token:', error);
        }
    }

    setupEventListeners() {
        // Refresh token before form submission
        document.addEventListener('submit', (e) => {
            if (e.target.hasAttribute('data-livewire')) {
                this.ensureValidToken();
            }
        });

        // Refresh token before Livewire requests
        if (window.Livewire) {
            window.Livewire.hook('message.sent', () => {
                this.ensureValidToken();
            });
        }

        // Refresh token on user activity
        let activityTimeout;
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                clearTimeout(activityTimeout);
                activityTimeout = setTimeout(() => {
                    this.ensureValidToken();
                }, 30000); // 30 seconds after last activity
            });
        });
    }

    ensureValidToken() {
        const now = Date.now();
        const timeSinceLastRefresh = now - this.lastTokenRefresh;
        
        // If token is older than 10 minutes, refresh it
        if (timeSinceLastRefresh > 600000) { // 10 minutes
            this.refreshToken();
        }
    }

    destroy() {
        if (this.tokenRefreshInterval) {
            clearInterval(this.tokenRefreshInterval);
            this.tokenRefreshInterval = null;
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.csrfTokenManager = new CsrfTokenManager();
});

// Export for use in other modules
export default CsrfTokenManager;
