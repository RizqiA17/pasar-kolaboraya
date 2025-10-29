<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasar Kolaboraya API Documentation - {{ $version }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --heading-color: #212529;
            --text-color: #495057;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
            --border-color: #dee2e6;
            --code-bg: #f8f9fa;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }
        h1, h2, h3, h4 {
            color: var(--heading-color);
            font-weight: 600;
        }
        .api-sidebar {
            background-color: var(--light-bg);
            border-right: 1px solid var(--border-color);
            height: 100vh;
            position: sticky;
            top: 0;
            padding-top: 1.5rem;
            overflow-y: auto;
        }
        .api-sidebar .nav-link {
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .api-sidebar .nav-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }
        .api-sidebar .nav-link.active {
            color: var(--primary-color);
            font-weight: 600;
        }
        .endpoint {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            background-color: white;
        }
        .endpoint-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .method {
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            margin-right: 1rem;
            color: white;
        }
        .method.get {
            background-color: #28a745;
        }
        .method.post {
            background-color: #0d6efd;
        }
        .url {
            font-family: monospace;
            font-size: 1rem;
        }
        .endpoint-description {
            margin-bottom: 1rem;
        }
        .section-heading {
            font-weight: 600;
            margin: 1.5rem 0 0.75rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .param-table th {
            background-color: var(--light-bg);
        }
        code {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.9em;
        }
        .code-block {
            background-color: var(--code-bg);
            padding: 1rem;
            border-radius: 0.5rem;
            margin: 1rem 0;
            overflow-x: auto;
            font-size: 0.9rem;
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .auth-badge {
            background-color: #6f42c1;
        }
        .signature-badge {
            background-color: #fd7e14;
        }
        .apikey-badge {
            background-color: #20c997;
        }
        .content-section {
            padding: 2rem 0;
        }
        .top-heading {
            margin-bottom: 2rem;
        }
        .warning {
            color: #dc3545;
            font-weight: 600;
        }
        .code-tabs .nav-link {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .api-version {
            font-size: 1rem;
            color: var(--secondary-color);
            margin-left: 0.5rem;
            font-weight: normal;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-md-3 col-lg-2 api-sidebar">
                <h5 class="px-3 mb-3">API Documentation</h5>
                <nav class="nav flex-column">
                    <a class="nav-link" href="#introduction">Introduction</a>
                    <a class="nav-link" href="#authentication">Authentication</a>
                    <a class="nav-link" href="#rate-limiting">Rate Limiting</a>
                    <a class="nav-link" href="#error-handling">Error Handling</a>
                    
                    <h6 class="mt-4 px-3">Endpoints</h6>
                    <a class="nav-link" href="#users-qr">Get User by QR Code</a>
                    <a class="nav-link" href="#users-id">Get User by ID</a>
                    <a class="nav-link" href="#users-list">Get Users List</a>
                    
                    <h6 class="mt-4 px-3">Client Examples</h6>
                    <a class="nav-link" href="#client-examples">Example Code</a>
                    <a class="nav-link" href="#setup">Setup Instructions</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-12 col-md-9 col-lg-10 px-4">
                <div class="content-section" id="introduction">
                    <h1 class="top-heading">Pasar Kolaboraya API <span class="api-version">{{ strtoupper($version) }}</span></h1>
                    
                    <p>
                        Welcome to the Pasar Kolaboraya API documentation for external application integration. 
                        This API allows your application to interact with user data from the Pasar Kolaboraya platform 
                        using secure app-to-app authentication.
                    </p>
                    
                    <div class="alert alert-info" role="alert">
                        <strong>Base URL:</strong> <code>https://{{ $domain }}/api/{{ $version }}/app</code>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Application-to-Application Integration <span class="badge apikey-badge float-end">API Key</span></h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        This API is designed for external applications to integrate with Pasar Kolaboraya 
                                        without requiring user login. Authentication is handled through API Key and Secret pairs.
                                    </p>
                                    <ul>
                                        <li><strong>Authentication:</strong> API Key + Secret</li>
                                        <li><strong>Rate Limit:</strong> 100 requests per minute</li>
                                        <li><strong>Use Case:</strong> External systems, mobile apps, integrations</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-section" id="authentication">
                    <h2>Authentication</h2>
                    
                    <p>
                        All API requests must be authenticated using API Key and Secret credentials. 
                        These credentials are provided when you register your application with Pasar Kolaboraya.
                    </p>
                    
                    <div class="alert alert-warning" role="alert">
                        <strong>Security Notice:</strong> Never expose your API Key and Secret in client-side code or public repositories. 
                        Keep them secure on your server.
                    </div>
                    
                    <h3 class="section-heading">Required Headers</h3>
                    
                    <p>Include these headers in every API request:</p>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Header</th>
                                <th>Description</th>
                                <th>Example</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>X-API-Key</code></td>
                                <td>Your application's API key</td>
                                <td><code>your_api_key_here</code></td>
                            </tr>
                            <tr>
                                <td><code>X-API-Secret</code></td>
                                <td>Your application's API secret</td>
                                <td><code>your_api_secret_here</code></td>
                            </tr>
                            <tr>
                                <td><code>Accept</code></td>
                                <td>Specify response format</td>
                                <td><code>application/json</code></td>
                            </tr>
                            <tr>
                                <td><code>Content-Type</code></td>
                                <td>Request body format (for POST requests)</td>
                                <td><code>application/json</code></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h3 class="section-heading">Example Request</h3>
                    <div class="code-block">
<pre><code class="language-http">GET /api/{{ $version }}/app/users HTTP/1.1
Host: {{ $domain }}
X-API-Key: your_api_key_here
X-API-Secret: your_api_secret_here
Accept: application/json</code></pre>
                    </div>
                </div>
                
                <div class="content-section" id="rate-limiting">
                    <h2>Rate Limiting</h2>
                    
                    <p>
                        The API implements rate limiting to protect server resources and ensure fair usage for all applications.
                    </p>
                    
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading">Current Rate Limit</h5>
                        <p class="mb-0"><strong>100 requests per minute</strong> per API Key</p>
                    </div>
                    
                    <h3 class="section-heading">Rate Limit Response Headers</h3>
                    <p>Each API response includes headers that indicate your current rate limit status:</p>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Header</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>X-RateLimit-Limit</code></td>
                                <td>Maximum number of requests allowed per minute (100)</td>
                            </tr>
                            <tr>
                                <td><code>X-RateLimit-Remaining</code></td>
                                <td>Number of requests remaining in the current minute</td>
                            </tr>
                            <tr>
                                <td><code>Retry-After</code></td>
                                <td>Seconds to wait before retrying (only present when limit is reached)</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h3 class="section-heading">Handling Rate Limits</h3>
                    <p>When you exceed the rate limit, you'll receive a <code>429 Too Many Requests</code> response:</p>
                    
                    <div class="code-block">
<pre><code class="language-json">{
    "status": "error",
    "message": "Too Many Requests"
}</code></pre>
                    </div>
                    
                    <div class="alert alert-warning" role="alert">
                        <strong>Best Practice:</strong> Implement exponential backoff and respect the <code>Retry-After</code> header 
                        when you receive a 429 response. Monitor the <code>X-RateLimit-Remaining</code> header to avoid hitting the limit.
                    </div>
                </div>
                
                <div class="content-section" id="error-handling">
                    <h2>Error Handling</h2>
                    
                    <p>
                        The API uses conventional HTTP response codes to indicate the success or failure of an API request.
                    </p>
                    
                    <h3 class="section-heading">HTTP Status Codes</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>200 OK</td>
                                <td>The request was successful</td>
                            </tr>
                            <tr>
                                <td>400 Bad Request</td>
                                <td>Invalid request parameters or QR code</td>
                            </tr>
                            <tr>
                                <td>401 Unauthorized</td>
                                <td>Authentication failed (invalid token or API key)</td>
                            </tr>
                            <tr>
                                <td>403 Forbidden</td>
                                <td>The request is not allowed (invalid signature or timestamp)</td>
                            </tr>
                            <tr>
                                <td>404 Not Found</td>
                                <td>The requested resource was not found</td>
                            </tr>
                            <tr>
                                <td>422 Unprocessable Entity</td>
                                <td>Validation errors</td>
                            </tr>
                            <tr>
                                <td>429 Too Many Requests</td>
                                <td>Rate limit exceeded</td>
                            </tr>
                            <tr>
                                <td>500 Internal Server Error</td>
                                <td>Server error</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h3 class="section-heading">Error Response Format</h3>
                    <div class="code-block">
<pre><code class="language-json">{
    "status": "error",
    "message": "Error message describing what went wrong",
    "errors": {
        "field_name": [
            "Validation error message"
        ]
    }
}</code></pre>
                    </div>
                </div>

                <!-- Endpoints -->
                <h2 class="mt-5">API Endpoints</h2>
                
                <div class="endpoint" id="users-qr">
                    <div class="endpoint-header">
                        <span class="method post">POST</span>
                        <span class="url">/{{ $version }}/app/users/qr</span>
                    </div>
                    
                    <div class="endpoint-description">
                        <p>Get user data by QR code.</p>
                    </div>
                    
                    <h4 class="section-heading">Request Parameters</h4>
                    <table class="table table-bordered param-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>qr_code</code></td>
                                <td>string</td>
                                <td>Yes</td>
                                <td>The QR code identifier</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h4 class="section-heading">Example Request</h4>
                    <div class="code-block">
<pre><code class="language-http">POST /api/{{ $version }}/app/users/qr HTTP/1.1
Host: {{ $domain }}
X-API-Key: your_api_key_here
X-API-Secret: your_api_secret_here
Content-Type: application/json
Accept: application/json

{
    "qr_code": "PK_1_1698765432_abc123"
}</code></pre>
                    </div>
                    
                    <h4 class="section-heading">Example Response</h4>
                    <div class="code-block">
<pre><code class="language-json">{
    "status": "success",
    "message": "User data retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "organization_name": "ABC Organization",
        "user_type": "partisipan",
        "approval_status": "approved",
        "is_ecosystem_builder": true,
        "profile": {
            "id": 1,
            "bio": "Lorem ipsum dolor sit amet",
            "peran": [
                {
                    "id": 1,
                    "name": "Developer"
                }
            ],
            "interests": [
                {
                    "id": 1,
                    "name": "Technology"
                }
            ],
            "skills": [
                {
                    "id": 1,
                    "name": "Programming"
                }
            ]
        }
    }
}</code></pre>
                    </div>
                </div>
                
                <div class="endpoint" id="users-id">
                    <div class="endpoint-header">
                        <span class="method get">GET</span>
                        <span class="url">/{{ $version }}/app/users/{id}</span>
                    </div>
                    
                    <div class="endpoint-description">
                        <p>Get user data by ID.</p>
                    </div>
                    
                    <h4 class="section-heading">Path Parameters</h4>
                    <table class="table table-bordered param-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>id</code></td>
                                <td>integer</td>
                                <td>Yes</td>
                                <td>The user ID</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h4 class="section-heading">Example Request</h4>
                    <div class="code-block">
<pre><code class="language-http">GET /api/{{ $version }}/app/users/1 HTTP/1.1
Host: {{ $domain }}
X-API-Key: your_api_key_here
X-API-Secret: your_api_secret_here
Accept: application/json</code></pre>
                    </div>
                    
                    <h4 class="section-heading">Example Response</h4>
                    <div class="code-block">
<pre><code class="language-json">{
    "status": "success",
    "message": "User data retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "organization_name": "ABC Organization",
        "user_type": "partisipan",
        "approval_status": "approved",
        "is_ecosystem_builder": true,
        "profile": {
            "id": 1,
            "bio": "Lorem ipsum dolor sit amet",
            "peran": [
                {
                    "id": 1,
                    "name": "Developer"
                }
            ],
            "interests": [
                {
                    "id": 1,
                    "name": "Technology"
                }
            ],
            "skills": [
                {
                    "id": 1,
                    "name": "Programming"
                }
            ]
        }
    }
}</code></pre>
                    </div>
                </div>
                
                <div class="endpoint" id="users-list">
                    <div class="endpoint-header">
                        <span class="method get">GET</span>
                        <span class="url">/{{ $version }}/app/users</span>
                    </div>
                    
                    <div class="endpoint-description">
                        <p>Get a paginated list of users with filtering options.</p>
                    </div>
                    
                    <h4 class="section-heading">Query Parameters</h4>
                    <table class="table table-bordered param-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>per_page</code></td>
                                <td>integer</td>
                                <td>No</td>
                                <td>Number of items per page (default: 15, max: 100)</td>
                            </tr>
                            <tr>
                                <td><code>page</code></td>
                                <td>integer</td>
                                <td>No</td>
                                <td>Page number (default: 1)</td>
                            </tr>
                            <tr>
                                <td><code>approval_status</code></td>
                                <td>string</td>
                                <td>No</td>
                                <td>Filter by approval status: pending, approved, rejected</td>
                            </tr>
                            <tr>
                                <td><code>user_type</code></td>
                                <td>string</td>
                                <td>No</td>
                                <td>Filter by user type: partisipan, tamu, komunitas</td>
                            </tr>
                            <tr>
                                <td><code>is_ecosystem_builder</code></td>
                                <td>boolean</td>
                                <td>No</td>
                                <td>Filter by ecosystem builder status</td>
                            </tr>
                            <tr>
                                <td><code>search</code></td>
                                <td>string</td>
                                <td>No</td>
                                <td>Search term for name, email, or organization name</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <h4 class="section-heading">Example Request</h4>
                    <div class="code-block">
<pre><code class="language-http">GET /api/{{ $version }}/app/users?per_page=10&page=1&approval_status=approved&search=john HTTP/1.1
Host: {{ $domain }}
X-API-Key: your_api_key_here
X-API-Secret: your_api_secret_here
Accept: application/json</code></pre>
                    </div>
                    
                    <h4 class="section-heading">Example Response</h4>
                    <div class="code-block">
<pre><code class="language-json">{
    "status": "success",
    "message": "Users retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "organization_name": "ABC Organization",
            "user_type": "partisipan",
            "approval_status": "approved",
            "is_ecosystem_builder": true,
            "profile": {
                "id": 1,
                "bio": "Lorem ipsum dolor sit amet",
                "peran": [
                    {
                        "id": 1,
                        "name": "Developer"
                    }
                ]
            }
        },
        // More users...
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 45,
        "from": 1,
        "to": 10
    },
    "links": {
        "first": "https://{{ $domain }}/api/{{ $version }}/app/users?page=1",
        "last": "https://{{ $domain }}/api/{{ $version }}/app/users?page=5",
        "prev": null,
        "next": "https://{{ $domain }}/api/{{ $version }}/app/users?page=2"
    }
}</code></pre>
                    </div>
                </div>
                
                <!-- Client Examples -->
                <div class="content-section" id="client-examples">
                    <h2>Client Examples</h2>
                    
                    <h3 class="section-heading">PHP - Reusable Client Class</h3>
                    <p>
                        Below is a simple reusable PHP client for integrating with the API:
                    </p>
                    
                    <div class="code-block">
<pre><code class="language-php">&lt;?php
// PasarKolaborayaClient.php

class PasarKolaborayaClient
{
    private $baseUrl;
    private $apiKey;
    private $apiSecret;

    public function __construct($baseUrl, $apiKey, $apiSecret)
    {
        $this->baseUrl = rtrim($baseUrl, '/') . '/api/{{ $version }}/app';
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    private function request($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint;
        
        $ch = curl_init();
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-API-Key: ' . $this->apiKey,
            'X-API-Secret: ' . $this->apiSecret,
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

    public function getUserByQr($qrCode)
    {
        return $this->request('/users/qr', 'POST', ['qr_code' => $qrCode]);
    }

    public function getUserById($userId)
    {
        return $this->request('/users/' . $userId);
    }

    public function getUsers($params = [])
    {
        $query = http_build_query($params);
        $endpoint = '/users' . ($query ? '?' . $query : '');
        return $this->request($endpoint);
    }
}
</code></pre>
                    </div>
                    
                    <h3 class="section-heading">Using the Client</h3>
                    
                    <div class="code-block">
<pre><code class="language-php">&lt;?php
// Include client class
require_once 'PasarKolaborayaClient.php';

// Initialize client
$client = new PasarKolaborayaClient(
    'https://{{ $domain }}',
    'your_api_key_here',
    'your_api_secret_here'
);

// Get user by ID
$result = $client->getUserById(1);
if ($result['success']) {
    echo "User found: " . $result['data']['data']['name'];
} else {
    echo "Error: " . $result['error'];
}

// Get user by QR code
$result = $client->getUserByQr('PK_1_1698765432_abc123');
if ($result['success']) {
    echo "User found: " . $result['data']['data']['name'];
} else {
    echo "Error: " . $result['error'];
}

// Search for users
$result = $client->getUsers([
    'search' => 'john',
    'per_page' => 10,
    'approval_status' => 'approved'
]);
if ($result['success']) {
    echo "Found " . $result['data']['meta']['total'] . " users";
    foreach ($result['data']['data'] as $user) {
        echo "- " . $user['name'] . " (" . $user['email'] . ")";
    }
} else {
    echo "Error: " . $result['error'];
}
</code></pre>
                    </div>
                </div>
                
                <!-- Setup Instructions -->
                <div class="content-section" id="setup">
                    <h2>Setup Instructions for External Applications</h2>
                    
                    <p>Follow these steps to integrate your external application with the Pasar Kolaboraya API:</p>
                    
                    <h3 class="section-heading">Step 1: Request API Credentials</h3>
                    <p>
                        Contact the Pasar Kolaboraya admin team to request API Key and Secret for your external application.
                        Provide the following information:
                    </p>
                    
                    <ul>
                        <li>Application name</li>
                        <li>Purpose of integration</li>
                        <li>Expected request volume</li>
                        <li>Technical contact person</li>
                    </ul>
                    
                    <p class="mt-3">
                        The admin team will generate credentials and provide you with:
                    </p>
                    
                    <ul>
                        <li><strong>API Key</strong> - Public identifier for your application</li>
                        <li><strong>API Secret</strong> - Private key that must be kept secure</li>
                    </ul>
                    
                    <div class="alert alert-info" role="alert">
                        <strong>Note:</strong> The API Secret will only be shown once during generation. 
                        Make sure to save it securely before closing the message.
                    </div>
                    
                    <h3 class="section-heading">Step 2: Store Credentials Securely</h3>
                    <div class="alert alert-warning" role="alert">
                        <p><strong>Important Security Notes:</strong></p>
                        <ul class="mb-0">
                            <li>Never commit API credentials to source control</li>
                            <li>Store credentials in environment variables or secure configuration</li>
                            <li>Never expose credentials in client-side code</li>
                            <li>Implement credential rotation periodically (recommended every 6-12 months)</li>
                            <li>Keep API Secret confidential - treat it like a password</li>
                        </ul>
                    </div>
                    
                    <p class="mt-3">Example of storing credentials in environment variables:</p>
                    
                    <div class="code-block">
<pre><code class="language-bash"># .env file (never commit this file)
PASAR_KOLABORAYA_API_KEY=your_api_key_here
PASAR_KOLABORAYA_API_SECRET=your_api_secret_here
PASAR_KOLABORAYA_API_URL=https://{{ $domain }}/api/{{ $version }}/app</code></pre>
                    </div>
                    
                    <h3 class="section-heading">Step 3: Implement Client in Your Application</h3>
                    <p>
                        Use the PHP client class provided in the <a href="#client-examples">Client Examples</a> section, 
                        or implement your own client in your preferred programming language.
                    </p>
                    
                    <p>Example integration in your application:</p>
                    
                    <div class="code-block">
<pre><code class="language-php">&lt;?php
// config.php
return [
    'api_key' => getenv('PASAR_KOLABORAYA_API_KEY'),
    'api_secret' => getenv('PASAR_KOLABORAYA_API_SECRET'),
    'api_url' => getenv('PASAR_KOLABORAYA_API_URL'),
];

// app.php
require_once 'PasarKolaborayaClient.php';
$config = require 'config.php';

$client = new PasarKolaborayaClient(
    $config['api_url'],
    $config['api_key'],
    $config['api_secret']
);
</code></pre>
                    </div>
                    
                    <h3 class="section-heading">Step 4: Test Your Integration</h3>
                    <p>
                        Start with simple tests to verify your credentials and connection:
                    </p>
                    
                    <div class="code-block">
<pre><code class="language-php">&lt;?php
// Test connection with a simple user lookup
$result = $client->getUserById(1);

if ($result['success']) {
    echo "✓ API connection successful!\n";
    echo "User: " . $result['data']['data']['name'] . "\n";
} else {
    echo "✗ API error: " . $result['error'] . "\n";
    echo "Status code: " . $result['status_code'] . "\n";
}
</code></pre>
                    </div>
                    
                    <h3 class="section-heading">Step 5: Implement Error Handling</h3>
                    <p>
                        Ensure your application handles all API responses and errors gracefully:
                    </p>
                    
                    <ul>
                        <li>Check <code>success</code> flag in responses</li>
                        <li>Handle rate limiting (429 errors) with retry logic</li>
                        <li>Handle authentication failures (401/403 errors)</li>
                        <li>Implement proper logging for debugging</li>
                        <li>Add monitoring for API availability</li>
                    </ul>
                    
                    <h3 class="section-heading">Step 6: Go Live</h3>
                    <p>
                        Once testing is complete, you're ready to use the API in production:
                    </p>
                    
                    <ul>
                        <li>Ensure production credentials are properly secured</li>
                        <li>Monitor API usage and stay within rate limits</li>
                        <li>Subscribe to API updates and maintenance notifications</li>
                        <li>Keep your client code updated with the latest best practices</li>
                    </ul>
                </div>
                
                <footer class="mt-5 pt-5 border-top text-center text-muted mb-5">
                    <p>Pasar Kolaboraya API Documentation - {{ strtoupper($version) }}</p>
                    <p>Last Updated: October 29, 2025</p>
                </footer>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js"></script>
    <script>
        // Activate the first nav link
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.api-sidebar .nav-link');
            if (navLinks.length > 0) {
                navLinks[0].classList.add('active');
            }
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 20,
                            behavior: 'smooth'
                        });
                        
                        // Update active nav link
                        document.querySelectorAll('.api-sidebar .nav-link').forEach(link => {
                            link.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                });
            });
            
            // Highlight active section on scroll
            window.addEventListener('scroll', () => {
                const sections = document.querySelectorAll('.content-section, .endpoint');
                let currentSection = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 100;
                    if (window.pageYOffset >= sectionTop) {
                        currentSection = '#' + section.getAttribute('id');
                    }
                });
                
                document.querySelectorAll('.api-sidebar .nav-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === currentSection) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
