<?php
/**
 * Pasar Kolaboraya API Client - Simple Example
 * 
 * This example demonstrates how to access the API using only Sanctum token
 * (without signature verification)
 */

// Configuration
$baseUrl = 'http://yourdomain.com/api/v1';
$token = 'YOUR_SANCTUM_TOKEN_HERE';

/**
 * Make API Request
 */
function makeRequest($url, $method = 'GET', $data = null, $token = null)
{
    $ch = curl_init();
    
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
    ];
    
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
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
    curl_close($ch);
    
    return [
        'status_code' => $httpCode,
        'data' => json_decode($response, true),
    ];
}

// Example 1: Get User by QR Code
echo "=== Example 1: Get User by QR Code ===\n";
$result = makeRequest(
    $baseUrl . '/users/qr',
    'POST',
    ['qr_code' => 'PK_1_1698765432_abc123'],
    $token
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 2: Get User by ID
echo "=== Example 2: Get User by ID ===\n";
$userId = 1;
$result = makeRequest(
    $baseUrl . '/users/' . $userId,
    'GET',
    null,
    $token
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 3: Get Paginated Users
echo "=== Example 3: Get Paginated Users ===\n";
$result = makeRequest(
    $baseUrl . '/users?per_page=10&page=1&approval_status=approved',
    'GET',
    null,
    $token
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 4: Search Users
echo "=== Example 4: Search Users ===\n";
$result = makeRequest(
    $baseUrl . '/users?search=john&per_page=5',
    'GET',
    null,
    $token
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

