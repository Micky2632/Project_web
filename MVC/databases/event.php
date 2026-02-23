<?php
function createEvent($desc, $start, $end, $location, $max_people): bool {

    if(!isset($_SESSION['user_id'])){
        return false;
    }

    $conn = getConnection();

    $sql = "INSERT INTO event
            (user_id, description, start_date, end_date, location, max_people, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'open', NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "issssi",
        $_SESSION['user_id'], // i
        $desc,               // s
        $start,              // s (datetime)
        $end,                // s (datetime)
        $location,           // s
        $max_people          // i
    );

    return $stmt->execute();
}

function getEvents(): mysqli_result|bool {

    $conn = getConnection();

    $sql = "SELECT * FROM event 
            ORDER BY start_date ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result();
}