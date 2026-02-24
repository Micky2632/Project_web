<?php
// 2.2-2.7 หน้าจัดการกิจกรรม - ดูคนลงทะเบียน + อนุมัติ OTP + ปฏิเสธ

$result = myEvent();  // ดึงกิจกรรมที่ฉันสร้าง

renderView('my_event', [  // แสดงหน้า my_event
    'result' => $result,   // ส่งข้อมูลกิจกรรม
    'title' => 'My Event'  // ส่ง title
]);

exit;  // จบ
