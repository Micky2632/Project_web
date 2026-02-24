<?php
// ระบบออกจากระบบ (Logout)

session_destroy();  // ล้าง session ทั้งหมด

header('Location: /login');  // กลับไปหน้า login
exit;  // จบ
