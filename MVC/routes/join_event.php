<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!isset($_SESSION['user_id'])){
        header('Location: /login');
        exit;
    }

    $event_id = (int)$_POST['event_id'];

    $result = joinEvent($event_id, $_SESSION['user_id']);

    // สมัครเสร็จ → กลับหน้า home
    header('Location: /home');
    exit;
}