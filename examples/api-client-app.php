<?php
/**
 * Pasar Kolaboraya API Client - Application-to-Application
 * 
 * This example demonstrates how to access the API using API Key authentication
 * Perfect for local applications that need to access the API
 */

// Configuration
$baseUrl = 'http://localhost:8000/api/v1/app'; // Ganti dengan URL server Anda
$apiKey = 'pk_PqNzZJrneo430fx9LLNXaJk7JGaFvzey';
$apiSecret = 'Gu34dmvl52jkMAegiuhtaB1VgxshlGtYmv1FPdYpVkJfLZf55K6rpck0mzIcNBVb';

/**
 * Make API Request with API Key Authentication
 */
function makeApiRequest($url, $method = 'GET', $data = null, $apiKey = null, $apiSecret = null)
{
    $ch = curl_init();
    
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'X-API-Key: ' . $apiKey,
        'X-API-Secret: ' . $apiSecret,
    ];
    
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
            'status_code' => 0,
            'data' => ['error' => $error],
        ];
    }
    
    return [
        'status_code' => $httpCode,
        'data' => json_decode($response, true),
    ];
}

// Example 1: Get User by QR Code
echo "=== Example 1: Get User by QR Code ===\n";
$result = makeApiRequest(
    $baseUrl . '/users/qr',
    'POST',
    ['qr_code' => 'PK_1_1698765432_abc123'],
    $apiKey,
    $apiSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 2: Get User by ID
echo "=== Example 2: Get User by ID ===\n";
$userId = 7; // Use actual user ID from your database
$result = makeApiRequest(
    $baseUrl . '/users/' . $userId,
    'GET',
    null,
    $apiKey,
    $apiSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 3: Get Paginated Users
echo "=== Example 3: Get Paginated Users ===\n";
$result = makeApiRequest(
    $baseUrl . '/users?per_page=10&page=1',
    'GET',
    null,
    $apiKey,
    $apiSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 4: Search Users
echo "=== Example 4: Search Users ===\n";
$result = makeApiRequest(
    $baseUrl . '/users?search=admin&per_page=5',
    'GET',
    null,
    $apiKey,
    $apiSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 5: Error Handling - Invalid API Key
echo "=== Example 5: Test with Invalid API Key ===\n";
$result = makeApiRequest(
    $baseUrl . '/users/1',
    'GET',
    null,
    'invalid_key',
    'invalid_secret'
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n";
echo "(This should return 401 with 'Invalid or expired API key' error)\n\n";

