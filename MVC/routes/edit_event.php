<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$event_id = (int)($_GET['id'] ?? 0);

if (!$event_id) {
    header('Location: /profile');
    exit;
}

$event = getEventById($event_id);

if (!$event) {
    $_SESSION['msg'] = "ไม่พบกิจกรรม หรือคุณไม่มีสิทธิ์แก้ไข";
    header('Location: /profile');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $desc = trim($_POST['description'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $max_people = (int)($_POST['max_people'] ?? 0);
    $status = $_POST['status'] ?? 'open';

    if ($desc && $start && $end && $location && $max_people > 0) {
        if (updateEvent($event_id, $desc, $start, $end, $location, $max_people, $status)) {
            $_SESSION['msg'] = "แก้ไขกิจกรรมสำเร็จ ✅";
            header('Location: /profile');
            exit;
        } else {
            $_SESSION['msg'] = "เกิดข้อผิดพลาด กรุณาลองใหม่";
        }
    } else {
        $_SESSION['msg'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
    }
}

renderView('edit_event', ['event' => $event, 'title' => 'แก้ไขกิจกรรม']);
exit;
