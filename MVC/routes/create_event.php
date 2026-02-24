<?php
// 2.1 สร้างกิจกรรม - ผู้สร้างกิจกรรมสร้างได้มากกว่า 1 กิจกรรม

// เช็คว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){  // ถ้าส่งฟอร์ม

    $ok = createEvent(  // เรียกฟังก์ชันสร้างกิจกรรม
        $_POST['description'],      // รับคำอธิบาย
        $_POST['start_date'],      // รับวันเริ่ม
        $_POST['end_date'],        // รับวันจบ
        $_POST['location'],        // รับสถานที่
        (int)$_POST['max_people']  // รับจำนวนคนสูงสุด
    );

    if($ok){  // ถ้าสร้างสำเร็จ
        header('Location: /create_event');  // กลับไปหน้าสร้าง
        exit;  // จบ
    }

    renderView('create_event', ['error'=>'เพิ่มกิจกรรมไม่สำเร็จ']);  // แสดง error

} else {

    // ⭐ สำคัญมาก (GET ต้อง render form)
    renderView('create_event');  // แสดงฟอร์มสร้าง
}