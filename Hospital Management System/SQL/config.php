<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => '127.0.0.1',
    'path' => '/',
    'secure' => false,
    'httponly' => true,
]);

session_start();

if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30;

    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

$DATABASE_HOST = '127.0.0.1';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'hmsproject';
$DATABASE_PORT = 3306;

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME, $DATABASE_PORT);

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>
