<?php
// Google OAuth2 configuration
// IMPORTANT: Set your Google OAuth credentials from https://console.cloud.google.com/apis/credentials
return [
    'client_id' => 'YOUR_GOOGLE_CLIENT_ID',
    'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET',
    'redirect_uri' => 'http://localhost/NJ_MERCY_SHOP_COMPANY/?r=auth/googleCallback',
    'scopes' => ['email', 'profile'],
];
