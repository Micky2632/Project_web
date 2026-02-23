<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = register();

    if ($result === true) {
        header('Location: /login');
        exit;
    }

    if ($result === "duplicate") {
        renderView('register', ['error'=>'อีเมลนี้ถูกใช้แล้ว']);
        exit; // ⭐ สำคัญ
    }

    if ($result === "password_not_match") {
        renderView('register', ['error'=>'รหัสผ่านไม่ตรงกัน']);
        exit; // ⭐ สำคัญ
    }
}

// GET
renderView('register');