<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    /**
     * Display the API documentation page
     *
     * @param string $version API version
     * @return \Illuminate\View\View
     */
    public function index($version)
    {
        // Validate version
        if ($version !== 'v1') {
            abort(404, 'API version not found');
        }

        // Get example domain for documentation
        $domain = request()->getHost();
        
        return view('api.documentation', [
            'version' => $version,
            'domain' => $domain
        ]);
    }
}
