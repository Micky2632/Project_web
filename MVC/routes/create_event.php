<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $ok = createEvent(
        $_POST['description'],
        $_POST['start_date'],
        $_POST['end_date'],
        $_POST['location'],
        (int)$_POST['max_people']
    );

    if($ok){
        header('Location: /create_event');
        exit;
    }

    renderView('create_event', ['error'=>'เพิ่มกิจกรรมไม่สำเร็จ']);

} else {

    // ⭐ สำคัญมาก (GET ต้อง render form)
    renderView('create_event');
}