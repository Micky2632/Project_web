<?php
// 1.2 เข้าสู่ระบบ - ตรวจสอบอีเมลและรหัสผ่าน

// ถ้า login แล้ว ห้ามเข้าหน้า login ซ้ำ
if (isset($_SESSION['user_id'])) {
    header('Location: /home');  // ไปหน้าแรก
    exit;  // จบ
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // ถ้าส่งฟอร์ม

    $email = $_POST['email'] ?? '';  // รับอีเมล
    $password = $_POST['password'] ?? '';  // รับรหัสผ่าน

    $user = checkLogin($email, $password);  // ตรวจสอบ login

    if ($user) {  // ถ้าถูกต้อง

        $_SESSION['user_id'] = $user['user_id'];  // บันทึก session

        header('Location: /home');  // ไปหน้าแรก
        exit;
    } else {

        renderView('login', [  // แสดงหน้า login พร้อม error
            'error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
        ]);
        exit;
    }
} else {

    // ⭐ ห้าม include ตรง ๆ
    renderView('login');  // แสดงฟอร์ม login
}
