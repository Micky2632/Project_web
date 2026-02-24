<?php
// แสดง OTP ของผู้ใช้ - ถ้าหมดอายุจะสร้างใหม่

if (!isset($_SESSION['user_id'])) {
    $_SESSION['msg'] = "กรุณา login ก่อน";
    header('Location: /login');
    exit;
}

$event_id = (int)($_GET['event_id'] ?? 0);

if (!$event_id) {
    $_SESSION['msg'] = "ไม่พบ event_id";
    header('Location: /home');
    exit;
}

$data = getMyOTP($event_id, $_SESSION['user_id']);

// ถ้าไม่มีข้อมูล ให้ไปสมัครใหม่
if (!$data) {
    // ไปที่ join_event เพื่อสร้าง OTP ใหม่
    $_POST['event_id'] = $event_id;
    include 'join_event.php';
    exit;
}

// ถ้า OTP หมดอายุ ลบอันเก่าและสร้างใหม่
if (strtotime($data['otp_expire']) < time()) {
    $conn = getConnection();
    $del = $conn->prepare("DELETE FROM registrations WHERE event_id=? AND user_id=? AND status='pending'");
    $del->bind_param("ii", $event_id, $_SESSION['user_id']);
    $del->execute();
    
    // สร้าง OTP ใหม่โดยไปที่ join_event
    $_POST['event_id'] = $event_id;
    include 'join_event.php';
    exit;
}

$_SESSION['otp'] = $data['otp_code'];
$_SESSION['otp_expire'] = $data['otp_expire'];

header('Location: /home');
exit;