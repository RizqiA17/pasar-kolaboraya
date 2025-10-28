<?php
/**
 * Pasar Kolaboraya API Client Class
 * 
 * A reusable class for interacting with Pasar Kolaboraya API
 * Supports both simple and secure endpoints
 */

class PasarKolaborayaApiClient
{
    private $baseUrl;
    private $token;
    private $sharedSecret;
    private $useSecure;

    /**
     * Constructor
     * 
     * @param string $baseUrl Base URL of the API (without /v1 or /v1/secure)
     * @param string $token Sanctum Bearer Token
     * @param string|null $sharedSecret Shared secret for secure endpoints
     * @param bool $useSecure Whether to use secure endpoints (default: false)
     */
    public function __construct($baseUrl, $token, $sharedSecret = null, $useSecure = false)
    {
        $this->baseUrl = rtrim($baseUrl, '/') . '/v1';
        $this->token = $token;
        $this->sharedSecret = $sharedSecret;
        $this->useSecure = $useSecure && $sharedSecret !== null;

        if ($this->useSecure) {
            $this->baseUrl .= '/secure';
        }
    }

    /**
     * Generate HMAC signature
     */
    private function generateSignature($timestamp, $body)
    {
        return hash_hmac('sha256', $timestamp . $body, $this->sharedSecret);
    }

    /**
     * Make HTTP request
     */
    private function request($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint;
        $timestamp = time();
        $body = $data ? json_encode($data) : '';

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->token,
        ];

        // Add signature headers for secure endpoints
        if ($this->useSecure) {
            $signature = $this->generateSignature($timestamp, $body);
            $headers[] = 'X-Timestamp: ' . $timestamp;
            $headers[] = 'X-Signature: ' . $signature;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($body) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return [
                'success' => false,
                'status_code' => 0,
                'error' => $error,
                'data' => null,
            ];
        }

        $data = json_decode($response, true);

        return [
            'success' => $httpCode >= 200 && $httpCode < 300,
            'status_code' => $httpCode,
            'error' => $httpCode >= 400 ? ($data['message'] ?? 'Unknown error') : null,
            'data' => $data,
        ];
    }

    /**
     * Get user by QR code
     * 
     * @param string $qrCode The QR code to lookup
     * @return array Response data
     */
    public function getUserByQr($qrCode)
    {
        return $this->request('/users/qr', 'POST', ['qr_code' => $qrCode]);
    }

    /**
     * Get user by ID
     * 
     * @param int $userId User ID
     * @return array Response data
     */
    public function getUserById($userId)
    {
        return $this->request('/users/' . $userId);
    }

    /**
     * Get paginated list of users
     * 
     * @param array $params Query parameters (per_page, page, approval_status, etc.)
     * @return array Response data
     */
    public function getUsers($params = [])
    {
        $query = http_build_query($params);
        $endpoint = '/users' . ($query ? '?' . $query : '');
        return $this->request($endpoint);
    }

    /**
     * Search users
     * 
     * @param string $search Search query
     * @param int $perPage Items per page
     * @return array Response data
     */
    public function searchUsers($search, $perPage = 15)
    {
        return $this->getUsers([
            'search' => $search,
            'per_page' => $perPage,
        ]);
    }

    /**
     * Get approved users
     * 
     * @param int $perPage Items per page
     * @param int $page Page number
     * @return array Response data
     */
    public function getApprovedUsers($perPage = 15, $page = 1)
    {
        return $this->getUsers([
            'approval_status' => 'approved',
            'per_page' => $perPage,
            'page' => $page,
        ]);
    }

    /**
     * Get ecosystem builders
     * 
     * @param int $perPage Items per page
     * @param int $page Page number
     * @return array Response data
     */
    public function getEcosystemBuilders($perPage = 15, $page = 1)
    {
        return $this->getUsers([
            'is_ecosystem_builder' => true,
            'per_page' => $perPage,
            'page' => $page,
        ]);
    }
}

// ============================================================================
// USAGE EXAMPLES
// ============================================================================

// Example 1: Simple API Client (no signature)
echo "=== Example 1: Simple API Client ===\n";
$client = new PasarKolaborayaApiClient(
    'http://yourdomain.com/api',
    'YOUR_TOKEN_HERE'
);

$result = $client->getUserById(1);
if ($result['success']) {
    echo "User found: " . $result['data']['data']['name'] . "\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 2: Secure API Client (with signature)
echo "=== Example 2: Secure API Client ===\n";
$secureClient = new PasarKolaborayaApiClient(
    'http://yourdomain.com/api',
    'YOUR_TOKEN_HERE',
    'YOUR_SHARED_SECRET_HERE',
    true // Use secure endpoints
);

$result = $secureClient->getUserByQr('PK_1_1698765432_abc123');
if ($result['success']) {
    echo "User found: " . json_encode($result['data']['data'], JSON_PRETTY_PRINT) . "\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 3: Search Users
echo "=== Example 3: Search Users ===\n";
$result = $client->searchUsers('john', 10);
if ($result['success']) {
    echo "Found " . $result['data']['meta']['total'] . " users\n";
    foreach ($result['data']['data'] as $user) {
        echo "- " . $user['name'] . " (" . $user['email'] . ")\n";
    }
    echo "\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 4: Get Approved Users
echo "=== Example 4: Get Approved Users ===\n";
$result = $client->getApprovedUsers(20, 1);
if ($result['success']) {
    echo "Page " . $result['data']['meta']['current_page'] . " of " . $result['data']['meta']['last_page'] . "\n";
    echo "Total users: " . $result['data']['meta']['total'] . "\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 5: Get Ecosystem Builders
echo "=== Example 5: Get Ecosystem Builders ===\n";
$result = $secureClient->getEcosystemBuilders(10, 1);
if ($result['success']) {
    echo "Found " . $result['data']['meta']['total'] . " ecosystem builders\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

