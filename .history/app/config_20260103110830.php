<?php
// Basic config - update with your MySQL credentials
define('DB_HOST','127.0.0.1');
define('DB_NAME','retail_credit_system');
define('DB_USER','root');
define('DB_PASS','');

define('BASE_URL','/NJ_MERCY_SHOP_COMPANY');

// simple helper
function redirect($url){
    header('Location: ' . $url);
    exit;
}
