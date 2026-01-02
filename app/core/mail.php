<?php
// Simple mail utility for the app
function sendMail($to, $subject, $body, $from = null) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    if ($from) {
        $headers .= "From: $from\r\n";
    }
    return mail($to, $subject, $body, $headers);
}
