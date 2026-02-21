<?php
if($SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if(checkLogin($email,$password)) {
        header('Location: /students');
        exit;
    }else{
        renderView('login', ['error'=> 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
    }
}else{
    renderView('login');
}