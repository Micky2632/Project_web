<?php
function createEvent($desc, $start, $end, $location, $max_people): bool
{

    if (!isset($_SESSION['user_id'])) {
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

function getEvents(): mysqli_result|bool
{
    $conn = getConnection();

    $sql = '
        SELECT 
            e.*,
            COUNT(r.event_id) AS joined
        FROM event e
        LEFT JOIN registrations r
            ON e.event_id = r.event_id
        GROUP BY e.event_id
    ';

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result();
}

function joinEvent(int $event_id, int $user_id): bool|string {

    $conn = getConnection();

    // ✅ กันสมัครซ้ำ
    $check = $conn->prepare("
        SELECT 1 FROM registrations
        WHERE event_id = ? AND user_id = ?
    ");
    $check->bind_param("ii", $event_id, $user_id);
    $check->execute();

    if($check->get_result()->num_rows > 0){
        return "duplicate";
    }

    // ✅ เพิ่มข้อมูล
    $stmt = $conn->prepare("
        INSERT INTO registrations (event_id, user_id)
        VALUES (?, ?)
    ");
    $stmt->bind_param("ii", $event_id, $user_id);

    return $stmt->execute();
}
