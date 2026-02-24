<?php

$event_id = (int)($_GET['id'] ?? 0);

if (!$event_id) {
    header('Location: /home');
    exit;
}

$event = getEventDetails($event_id);
$stats = getEventStats($event_id);
$ageStats = getEventAgeStats($event_id);

if (!$event) {
    $_SESSION['msg'] = "ไม่พบกิจกรรม";
    header('Location: /home');
    exit;
}

renderView('event_detail', ['event' => $event, 'stats' => $stats, 'ageStats' => $ageStats, 'title' => $event['description']]);
exit;
