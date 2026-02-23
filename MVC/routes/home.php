<?php
// ประมวลผลก่อนแสดงผลหน้า

$result = getEvents();

renderView('home', [
    'title' => 'Home',
    'result' => $result
]);