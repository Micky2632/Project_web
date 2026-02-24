<?php
// 2.8 ดูสถิติกิจกรรม - แสดงจำนวนคนเข้าร่วมแต่ละสถานะ

// เช็คว่าผู้ใช้ล็อกอินแล้วหรือไม่
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

$event_id = (int)($_GET['event_id'] ?? 0);

if (!$event_id) {
    header('Location: /my_event');
    exit;
}

// เช็คว่าเป็นเจ้าของกิจกรรมหรือไม่
$event = getEventById($event_id);
if (!$event) {
    header('Location: /my_event');
    exit;
}

// ดึงสถิติ
$stats = getEventStats($event_id);

// ดึงรายชื่อคนตามสถานะ
$confirmed_users = getConfirmedUsers($event_id);
$pending_users = getPendingUsers($event_id);
$rejected_users = getRejectedUsers($event_id);

renderView('event_stats', [
    'title' => 'สถิติกิจกรรม',
    'event' => $event,
    'stats' => $stats,
    'confirmed_users' => $confirmed_users,
    'pending_users' => $pending_users,
    'rejected_users' => $rejected_users
]);

exit;
