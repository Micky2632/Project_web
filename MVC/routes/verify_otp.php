<?php
// 2.7 ตรวจสอบ OTP - ผู้จัดตรวจสอบ OTP ที่ผู้เข้าร่วมแสดง

$event_id = (int)($_POST['event_id'] ?? 0);  // รับ event_id จากฟอร์ม
$otp = trim($_POST['otp'] ?? '');  // รับ OTP แล้วตัดช่องว่าง

if(!$event_id || !$otp){  // ถ้าข้อมูลไม่ครบ
    header('Location: /my_event');  // กลับหน้า my_event
    exit;  // จบ
}

if(verifyOTP($event_id, $otp)){  // ถ้าตรวจสอบถูกต้อง
    $_SESSION['msg'] = "ยืนยันสำเร็จ ✅";  // บันทึกข้อความสำเร็จ
}else{
    $_SESSION['msg'] = "OTP ไม่ถูกต้อง ❌";  // บันทึกข้อความผิดพลาด
}

header('Location: /my_event');  // กลับหน้า my_event
exit;  // จบ