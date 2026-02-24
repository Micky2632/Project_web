<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$event_id = (int)($_GET['id'] ?? 0);

if (!$event_id) {
    $_SESSION['msg'] = "ไม่พบรหัสกิจกรรม";
    header('Location: /profile');
    exit;
}

if (deleteEvent($event_id)) {
    $_SESSION['msg'] = "ลบกิจกรรมสำเร็จ ✅";
} else {
    $_SESSION['msg'] = "ไม่สามารถลบกิจกรรมได้ ❌";
}

header('Location: /profile');
exit;
