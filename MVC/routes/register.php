<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    register();   // บันทึกข้อมูล
} else {
    include __DIR__ .'/../templates/register.php'; // แสดงฟอร์ม
}
