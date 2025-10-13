<?php

require_once 'vendor/autoload.php';

use App\Helpers\SocialLinkFormatter;

echo "=== TESTING BACKWARD COMPATIBILITY ===\n\n";

// Simulate old format data from database
$oldFormatData = [
    "github" => "https://github.com/asd",
    "twitter" => "rogahn.corrine", 
    "linkedin" => "mariam14",
    "instagram" => "asdas"
];

echo "1. Old format data from database:\n";
echo json_encode($oldFormatData, JSON_PRETTY_PRINT) . "\n\n";

echo "2. Testing Profile model accessor simulation:\n";
$socialMedia = $oldFormatData;

// Check if this is old format (key-value pairs)
$isOldFormat = false;
foreach ($socialMedia as $key => $val) {
    if (is_string($key) && is_string($val)) {
        $isOldFormat = true;
        break;
    }
}

echo "Is old format: " . ($isOldFormat ? 'YES' : 'NO') . "\n";

if ($isOldFormat) {
    echo "Converting using SocialLinkFormatter::convertOldFormat():\n";
    $convertedData = SocialLinkFormatter::convertOldFormat($socialMedia);
    echo json_encode($convertedData, JSON_PRETTY_PRINT) . "\n\n";
} else {
    echo "Already new format\n\n";
}

echo "3. Testing ProfileSetup loadSocialMediaData simulation:\n";
$socialMediaItems = [];

if (is_array($convertedData)) {
    foreach ($convertedData as $item) {
        if (is_array($item) && !empty($item['platform'])) {
            $socialMediaItems[] = [
                'platform' => $item['platform'],
                'username' => $item['username'] ?? '',
                'custom_link' => $item['custom_link'] ?? '',
                'use_custom_link' => !empty($item['custom_link'])
            ];
        }
    }
}

echo "ProfileSetup socialMediaItems:\n";
echo json_encode($socialMediaItems, JSON_PRETTY_PRINT) . "\n\n";

echo "4. Testing ProfileSettings loadSocialMediaData simulation:\n";
$profileSettingsItems = [];

// Simulate ProfileSettings logic
if (is_array($convertedData)) {
    // Check if it's old format (associative array with platform => url)
    $isOldFormat = false;
    foreach ($convertedData as $key => $val) {
        if (is_string($key) && is_string($val)) {
            $isOldFormat = true;
            break;
        }
    }
    
    if ($isOldFormat) {
        echo "ProfileSettings detected OLD format\n";
        // Convert old format to new format
        foreach ($convertedData as $platform => $url) {
            if (!empty($url)) {
                $profileSettingsItems[] = [
                    'platform' => $platform,
                    'username' => '',
                    'custom_link' => $url,
                    'use_custom_link' => true
                ];
            }
        }
    } else {
        echo "ProfileSettings detected NEW format\n";
        // New format
        foreach ($convertedData as $item) {
            if (is_array($item) && !empty($item['platform'])) {
                $profileSettingsItems[] = [
                    'platform' => $item['platform'],
                    'username' => $item['username'] ?? '',
                    'custom_link' => $item['custom_link'] ?? '',
                    'use_custom_link' => !empty($item['custom_link'])
                ];
            }
        }
    }
}

echo "ProfileSettings socialMediaItems:\n";
echo json_encode($profileSettingsItems, JSON_PRETTY_PRINT) . "\n\n";

echo "5. Testing URL generation for display:\n";
foreach ($profileSettingsItems as $index => $item) {
    $url = SocialLinkFormatter::generateProfileUrl(
        $item['platform'],
        $item['username'],
        $item['custom_link']
    );
    echo "Item $index: {$item['platform']} -> $url\n";
}

echo "\n=== TEST COMPLETED ===\n";
