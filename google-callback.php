<?php
// google-callback.php
session_start();
require_once 'api/db_connect.php';
require_once 'vendor/autoload.php';

$client = new Google\Client();
$client->setClientId('YOUR_GOOGLE_CLIENT_ID');
$client->setClientSecret('YOUR_GOOGLE_CLIENT_SECRET');
$client->setRedirectUri('https://your-site-url.com/google-callback.php');

// Verify the state token to prevent CSRF
if (!isset($_GET['code'])) {
    // If no code is sent, there was an error
    header('Location: login.php?error=access_denied');
    exit();
}

// Exchange the authorization code for an access token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token);

// Get user profile information from Google
$oauth = new Google\Service\Oauth2($client);
$userInfo = $oauth->userinfo->get();

// At this point, you have the user's email, name, and Google ID.
// You can now either create a new user in your database or log them in.
// Store the user's session and redirect them to your app's main page.
?>