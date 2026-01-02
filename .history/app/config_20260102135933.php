<?php
// Basic config - update with your MySQL credentials
define('DB_HOST','127.0.0.1');
define('DB_PORT','3306'); // adjust if MySQL runs on a non-default port (e.g., 3307 in XAMPP)
define('DB_NAME','retail_credit_system');
define('DB_USER','root');
define('DB_PASS','');

define('BASE_URL','/NY_MERCY_SHOP_COMPANY');

// simple helper
function redirect($url){
    header('Location: ' . $url);
    exit;
}
