<?php
function saveEventImage(int $event_id, string $path): void {

    $conn = getConnection();

    $stmt = $conn->prepare("
        INSERT INTO event_img (event_id, img_path)
        VALUES (?, ?)
    ");

    $stmt->bind_param("is", $event_id, $path);
    $stmt->execute();
}