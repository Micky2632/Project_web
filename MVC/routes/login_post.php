<?php

declare(strict_types=1);


// Assume that login success
$unix_timestamp = time();
$_SESSION['timestamp'] = $unix_timestamp;

header('Location: /');
