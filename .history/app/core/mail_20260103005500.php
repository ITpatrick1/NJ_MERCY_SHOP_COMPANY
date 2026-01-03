<?php
// Simple mail utility for the app
function sendMail($to, $subject, $body, $from = null) {
    // Set default from email if not provided
    if (!$from) {
        $from = 'noreply@njmercyshop.com';
    }
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $from\r\n";
    
    return mail($to, $subject, $body, $headers);
}
