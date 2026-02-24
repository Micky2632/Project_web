<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$event_id = (int)($_POST['event_id'] ?? 0);
$otp = trim($_POST['otp'] ?? '');

if (!$event_id || !$otp) {
    $_SESSION['msg'] = "กรุณากรอกข้อมูลให้ครบ";
    header('Location: /my_event');
    exit;
}

if (rejectRegistration($event_id, $otp)) {
    $_SESSION['msg'] = "ปฏิเสธการลงทะเบียนสำเร็จ ✅";
} else {
    $_SESSION['msg'] = "ไม่พบรายการที่จะปฏิเสธ ❌";
}

header('Location: /my_event');
exit;
