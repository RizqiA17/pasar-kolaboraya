<?php
/**
 * Pasar Kolaboraya API Client - Secure Example
 * 
 * This example demonstrates how to access the secure API endpoints
 * with both Sanctum token and HMAC signature verification
 */

// Configuration
$baseUrl = 'http://yourdomain.com/api/v1/secure';
$token = 'YOUR_SANCTUM_TOKEN_HERE';
$sharedSecret = 'YOUR_API_SHARED_SECRET_HERE';

/**
 * Generate HMAC Signature
 */
function generateSignature($timestamp, $body, $secret)
{
    return hash_hmac('sha256', $timestamp . $body, $secret);
}

/**
 * Make Secure API Request
 */
function makeSecureRequest($url, $method = 'GET', $data = null, $token = null, $secret = null)
{
    $timestamp = time();
    $body = $data ? json_encode($data) : '';
    $signature = generateSignature($timestamp, $body, $secret);
    
    $ch = curl_init();
    
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'X-Timestamp: ' . $timestamp,
        'X-Signature: ' . $signature,
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
            'status_code' => 0,
            'data' => ['error' => $error],
        ];
    }
    
    return [
        'status_code' => $httpCode,
        'data' => json_decode($response, true),
    ];
}

// Example 1: Get User by QR Code (Secure)
echo "=== Example 1: Get User by QR Code (Secure) ===\n";
$result = makeSecureRequest(
    $baseUrl . '/users/qr',
    'POST',
    ['qr_code' => 'PK_1_1698765432_abc123'],
    $token,
    $sharedSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 2: Get User by ID (Secure)
echo "=== Example 2: Get User by ID (Secure) ===\n";
$userId = 1;
$result = makeSecureRequest(
    $baseUrl . '/users/' . $userId,
    'GET',
    null,
    $token,
    $sharedSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 3: Get Paginated Users (Secure)
echo "=== Example 3: Get Paginated Users (Secure) ===\n";
$result = makeSecureRequest(
    $baseUrl . '/users?per_page=10&page=1',
    'GET',
    null,
    $token,
    $sharedSecret
);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n\n";

// Example 4: Error Handling
echo "=== Example 4: Test with Invalid Signature ===\n";
// This should fail with "Invalid signature" error
function makeInvalidRequest($url, $token)
{
    $timestamp = time();
    $wrongSignature = 'invalid_signature_12345';
    
    $ch = curl_init();
    
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        'X-Timestamp: ' . $timestamp,
        'X-Signature: ' . $wrongSignature,
        'Authorization: Bearer ' . $token,
    ];
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'status_code' => $httpCode,
        'data' => json_decode($response, true),
    ];
}

$result = makeInvalidRequest($baseUrl . '/users/1', $token);
echo "Status: " . $result['status_code'] . "\n";
echo "Response: " . json_encode($result['data'], JSON_PRETTY_PRINT) . "\n";
echo "(This should return 403 with 'Invalid signature' error)\n\n";

