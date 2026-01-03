<?php
// Simple mail utility for the app

// Lightweight env helper (supports .env, getenv, $_ENV)
function mailEnv($key, $default = null) {
    static $cachedEnv = null;

    if ($cachedEnv === null) {
        $cachedEnv = [];
        $envPath = __DIR__ . '/../../.env';
        if (file_exists($envPath)) {
            $parsed = parse_ini_file($envPath, false, INI_SCANNER_RAW);
            if (is_array($parsed)) {
                $cachedEnv = $parsed;
            }
        }
    }

    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }

    $val = getenv($key);
    if ($val !== false && $val !== null && $val !== '') {
        return $val;
    }

    if (array_key_exists($key, $cachedEnv)) {
        return $cachedEnv[$key];
    }

    return $default;
}

function normalizeMailPath($path) {
    if (!$path) return null;

    // Absolute paths (Windows or *nix)
    if (preg_match('/^[A-Za-z]:\\\\|^\//', $path)) {
        return $path;
    }

    return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . ltrim($path, '/\\');
}

function logMail($message) {
    $logFile = normalizeMailPath(mailEnv('MAIL_LOG_FILE', __DIR__ . '/../../mail.log'));
    $dir = $logFile ? dirname($logFile) : null;
    if ($dir && !is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    $timestamp = date('Y-m-d H:i:s');
    if ($logFile) {
        @file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
    }
}

function sendMail($to, $subject, $body, $from = null) {
    // Defaults and headers
    $from = $from ?: mailEnv('MAIL_FROM', 'noreply@njmercyshop.com');
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $from\r\n";

    $driver = strtolower(trim((string) mailEnv('MAIL_DRIVER', 'log')));

    // Driver: log (default) — avoids localhost SMTP warnings
    if ($driver === 'log' || $driver === '') {
        logMail("[LOG] To: {$to}; Subject: {$subject}; From: {$from}; Body: " . strip_tags($body));
        return true;
    }

    // Driver: smtp — uses PHP's mail() with configured host/port
    if ($driver === 'smtp') {
        $host = mailEnv('SMTP_HOST');
        $port = mailEnv('SMTP_PORT');

        if (!$host) {
            logMail("[SKIP] SMTP_HOST not set; email to {$to} not sent.");
            return true;
        }

        ini_set('SMTP', $host);
        if ($port) {
            ini_set('smtp_port', $port);
        }
        ini_set('sendmail_from', $from);

        $sent = @mail($to, $subject, $body, $headers);
        if (!$sent) {
            logMail("[FAIL] SMTP send failed to {$to} via {$host}:{$port}");
        }
        return $sent;
    }

    // Fallback: log when driver is unknown
    logMail("[LOG] Unknown MAIL_DRIVER '{$driver}'. Email to {$to} logged instead of sent.");
    return true;
}
