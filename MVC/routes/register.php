<?php
// 1.1 สมัครสมาชิก - บุคคลทั่วไปสมัครเป็นสมาชิก

$result = register();  // เรียกฟังก์ชันสมัครสมาชิก

if ($result === true) {  // ถ้าสมัครสำเร็จ
    header('Location: /login');  // ไปหน้า login
    exit;  // จบ
}

if ($result === "duplicate") {  // ถ้าอีเมลซ้ำ
    renderView('register', ['error'=>'อีเมลนี้ถูกใช้แล้ว']);  // แสดง error
    exit;  // จบ
}

if ($result === "password_not_match") {  // ถ้ารหัสไม่ตรงกัน
    renderView('register', ['error'=>'รหัสผ่านไม่ตรงกัน']);  // แสดง error
    exit;  // จบ
}

if ($result === "invalid") {  // ถ้ากรอกไม่ครบ
    renderView('register', ['error'=>'กรอกข้อมูลไม่ครบ']);  // แสดง error
    exit;  // จบ
}

renderView('register');  // แสดงฟอร์มสมัครสมาชิก