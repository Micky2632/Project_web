<?php
// หน้าแรก - แสดงกิจกรรมทั้งหมด + ค้นหา (3.1)

$user_id = $_SESSION['user_id'] ?? 0;  // ดึง user_id จาก session

// ตรวจสอบว่ามีการค้นหาหรือไม่
$keyword = $_GET['keyword'] ?? '';  // รับคำค้นหา
$start_date = $_GET['start'] ?? '';  // รับวันเริ่ม
$end_date = $_GET['end'] ?? '';  // รับวันจบ

if (!empty($keyword) || !empty($start_date) || !empty($end_date)) {
    // ใช้ฟังก์ชันค้นหา
    $result = searchEvents($keyword, $start_date, $end_date);  // ค้นหา
} else {
    // แสดงทั้งหมด
    $result = getAllEventsWithStatus($user_id);  // ดึงทั้งหมด
}

renderView('home', [  // แสดงหน้า home
    'title' => 'Home',
    'result' => $result,
    'keyword' => $keyword,
    'start_date' => $start_date,
    'end_date' => $end_date
]);