<?php
declare(strict_types=1);

// Load configuration and TOTP functions
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/totp.php';

function getConnection(): mysqli
{
    $hostname = 'localhost';
    $dbName = 'event_system';
    $username = 'Event';
    $password = '1234';
    $conn = new mysqli($hostname, $username, $password, $dbName);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

require_once DATABASES_DIR . '/users.php';
require_once DATABASES_DIR . '/registrations.php';
require_once DATABASES_DIR . '/event.php';
require_once DATABASES_DIR . '/event_img.php';

