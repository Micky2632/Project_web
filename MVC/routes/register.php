<?php
$result = register();

if ($result === true) {
    header('Location: /login');
    exit;
}

if ($result === "duplicate") {
    renderView('register', ['error'=>'อีเมลนี้ถูกใช้แล้ว']);
    exit;
}

if ($result === "password_not_match") {
    renderView('register', ['error'=>'รหัสผ่านไม่ตรงกัน']);
    exit;
}

if ($result === "invalid") {
    renderView('register', ['error'=>'กรอกข้อมูลไม่ครบ']);
    exit;
}

renderView('register');