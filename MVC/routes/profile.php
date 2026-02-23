<?php
$result = getUsers();
renderView('profile',['result' => $result, 'title' => 'Profile']);