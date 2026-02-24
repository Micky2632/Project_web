<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$user = getUsers();
$myEvents = myEvent();
$myRegEvents = myRegEvent();

renderView('profile', [
    'user' => $user,
    'myEvents' => $myEvents,
    'myRegEvents' => $myRegEvents,
    'title' => 'Profile'
]);
exit;