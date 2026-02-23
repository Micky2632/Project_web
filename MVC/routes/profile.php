<?php

$result = getUsers();
renderView('profile', ['result' => $result,'title' => 'Profile']);
var_dump($_SESSION);
exit;