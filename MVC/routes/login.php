<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = checkLogin($email, $password);

    if ($user) {

        $_SESSION['user_id'] = $user['user_id']; // ⭐⭐ ตัวสำคัญ

        header('Location: /home');
        exit;
    } else {

        renderView('login', [
            'error' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'
        ]);
        exit;
    }
} else {

    // ⭐ ห้าม include ตรง ๆ
    renderView('login');
}
