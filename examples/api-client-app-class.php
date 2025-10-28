<?php
/**
 * Pasar Kolaboraya API Client Class - Application Version
 * 
 * A reusable class for application-to-application API access
 * Uses API Key authentication instead of user tokens
 */

class PasarKolaborayaAppApiClient
{
    private $baseUrl;
    private $apiKey;
    private $apiSecret;

    /**
     * Constructor
     * 
     * @param string $baseUrl Base URL of the API (without /v1/app)
     * @param string $apiKey API Key
     * @param string $apiSecret API Secret
     */
    public function __construct($baseUrl, $apiKey, $apiSecret)
    {
        $this->baseUrl = rtrim($baseUrl, '/') . '/v1/app';
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Make HTTP request with API Key authentication
     */
    private function request($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-Key: ' . $this->apiKey,
            'X-API-Secret: ' . $this->apiSecret,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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

// Example 1: Initialize client
echo "=== Example 1: Initialize API Client ===\n";
$client = new PasarKolaborayaAppApiClient(
    'http://localhost:8000/api',  // Updated URL
    'pk_PqNzZJrneo430fx9LLNXaJk7JGaFvzey',  // Your API Key
    'Gu34dmvl52jkMAegiuhtaB1VgxshlGtYmv1FPdYpVkJfLZf55K6rpck0mzIcNBVb'  // Your API Secret
);

// Example 2: Get User by ID
echo "=== Example 2: Get User by ID ===\n";
$result = $client->getUserById(7); // Use actual user ID
if ($result['success']) {
    echo "User found: " . $result['data']['data']['name'] . "\n";
    echo "Email: " . $result['data']['data']['email'] . "\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 3: Get User by QR Code
echo "=== Example 3: Get User by QR Code ===\n";
$result = $client->getUserByQr('PK_7_1698765432_abc123'); // Use actual QR code
if ($result['success']) {
    echo "User found: " . json_encode($result['data']['data'], JSON_PRETTY_PRINT) . "\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 4: Search Users
echo "=== Example 4: Search Users ===\n";
$result = $client->searchUsers('admin', 10);
if ($result['success']) {
    echo "Found " . $result['data']['meta']['total'] . " users\n";
    foreach ($result['data']['data'] as $user) {
        echo "- " . $user['name'] . " (" . $user['email'] . ")\n";
    }
    echo "\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 5: Get Approved Users
echo "=== Example 5: Get Approved Users ===\n";
$result = $client->getApprovedUsers(20, 1);
if ($result['success']) {
    echo "Page " . $result['data']['meta']['current_page'] . " of " . $result['data']['meta']['last_page'] . "\n";
    echo "Total users: " . $result['data']['meta']['total'] . "\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

// Example 6: Get Ecosystem Builders
echo "=== Example 6: Get Ecosystem Builders ===\n";
$result = $client->getEcosystemBuilders(10, 1);
if ($result['success']) {
    echo "Found " . $result['data']['meta']['total'] . " ecosystem builders\n\n";
} else {
    echo "Error: " . $result['error'] . "\n\n";
}

