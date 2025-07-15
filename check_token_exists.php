<?php
// Check if token exists in database
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Laravel\Sanctum\PersonalAccessToken;

echo "Checking token: 1|QppBUCscrKuGiwuSGsUdJ7xzwqyQMoZJG7dHXtlk365374c1\n";
echo "Looking for hashed token in database...\n\n";

$tokenString = 'QppBUCscrKuGiwuSGsUdJ7xzwqyQMoZJG7dHXtlk365374c1';
$hashedToken = hash('sha256', $tokenString);

echo "Token string: " . $tokenString . "\n";
echo "Hashed token: " . $hashedToken . "\n\n";

$token = PersonalAccessToken::where('token', $hashedToken)->first();

if ($token) {
    echo "✅ TOKEN FOUND!\n";
    echo "Token ID: " . $token->id . "\n";
    echo "User ID: " . $token->tokenable_id . "\n";
    echo "Name: " . $token->name . "\n";
    echo "Created: " . $token->created_at . "\n";
    echo "Expires: " . $token->expires_at . "\n";
    echo "Last used: " . $token->last_used_at . "\n";
    
    // Check if expired
    if ($token->expires_at && $token->expires_at->isPast()) {
        echo "⚠️  Token is EXPIRED!\n";
    } else {
        echo "✅ Token is still VALID!\n";
    }
} else {
    echo "❌ TOKEN NOT FOUND in database!\n";
    echo "This means the token either:\n";
    echo "- Was never created\n";
    echo "- Was deleted/expired\n";
    echo "- The token string is incorrect\n";
    
    // Show all tokens for debugging
    echo "\nAll tokens in database:\n";
    $allTokens = PersonalAccessToken::all();
    foreach ($allTokens as $t) {
        echo "- ID: {$t->id}, User: {$t->tokenable_id}, Name: {$t->name}, Created: {$t->created_at}\n";
    }
}
