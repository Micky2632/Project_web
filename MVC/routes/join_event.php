<?php
// 3.2 ลงทะเบียนขอเข้าร่วมกิจกรรม - สร้าง OTP อัตโนมัติ

$event_id = (int)($_POST['event_id'] ?? 0);  // รับ event_id จากฟอร์ม

if (!$event_id) {  // ถ้าไม่มี event_id
    header('Location: /home');  // กลับหน้าแรก
    exit;  // จบ
}

$result = joinEvent($event_id, $_SESSION['user_id']);  // เรียกฟังก์ชันลงทะเบียน

switch (true) {  // ตรวจสอบผลลัพธ์

    case $result === "closed":  // กิจกรรมปิด
        $_SESSION['msg'] = "กิจกรรมปิดแล้ว";  // บันทึกข้อความ
        break;  // ออก

    case $result === "full":  // คนเต็ม
        $_SESSION['msg'] = "คนเต็มแล้ว";  // บันทึกข้อความ
        break;  // ออก

    case $result === "duplicate":  // สมัครซ้ำ
        $_SESSION['msg'] = "คุณสมัครแล้ว";  // บันทึกข้อความ
        break;  // ออก

    // ⭐ OTP 6 หลัก
    case preg_match('/^\d{6}$/', $result):  // ถ้าเป็นรหัส 6 ตัว
        $_SESSION['otp'] = $result;  // บันทึก OTP สำหรับแสดงผล
        $_SESSION['otp_expire'] = date('Y-m-d H:i:s', time() + 1800);
        break;  // ออก

    default:  // กรณีอื่น
        $_SESSION['msg'] = "เกิดข้อผิดพลาด";  // บันทึกข้อความ
}

header('Location: /home');  // กลับหน้าแรก
exit;  // จบ