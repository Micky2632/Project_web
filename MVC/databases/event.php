<?php
// สร้างกิจกรรมใหม่ (2.1)
function createEvent($desc, $start, $end, $location, $max_people): bool  // รับข้อมูลกิจกรรม
{
    if (!isset($_SESSION['user_id'])) {  // เช็ค login
        return false;
    }

    $conn = getConnection();

    // ⭐ เพิ่ม event ก่อน
    $sql = "INSERT INTO event 
            (user_id, description, start_date, end_date, location, max_people, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, 'open', NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "issssi",
        $_SESSION['user_id'],
        $desc,
        $start,
        $end,
        $location,
        $max_people
    );

    if (!$stmt->execute()) {  // รัน SQL
        return false;
    }

    // ⭐ ดึง id ล่าสุด
    $event_id = $conn->insert_id;  // ดึง ID ที่เพิ่ม

    // ⭐ ถ้ามีรูป
    if (!empty($_FILES['images']['name'][0])) {  // เช็คมีรูปไหม

        $folder = "uploads/";

        foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {  // วนลูปรูป

            if (!$tmp) continue;  // ข้ามถ้าว่าง

            $filename = time() . "_" . $_FILES['images']['name'][$i];
            $path = $folder . $filename;

            move_uploaded_file($tmp, $path);  // ย้ายไฟล์

            // บันทึกลง table รูป
            $imgStmt = $conn->prepare("
                INSERT INTO event_img (event_id, img_path)
                VALUES (?, ?)
            ");

            $imgStmt->bind_param("is", $event_id, $path);
            $imgStmt->execute();
        }
    }

    return true;
}


function joinEvent(int $event_id, int $user_id): bool|string
{
    $conn = getConnection();

    // เช็คสถานะ + จำนวน confirmed เท่านั้น
    $checkEvent = $conn->prepare("
        SELECT 
            status,
            max_people,
            (SELECT COUNT(*) 
             FROM registrations 
             WHERE event_id = ? AND status='confirmed') AS joined
        FROM event
        WHERE event_id = ?
    ");

    $checkEvent->bind_param("ii", $event_id, $event_id);
    $checkEvent->execute();
    $event = $checkEvent->get_result()->fetch_assoc();

    if (!$event) return false;
    if ($event['status'] !== 'open') return "closed";
    if ($event['joined'] >= $event['max_people']) return "full";

    // กันซ้ำ - เช็คจาก database (เฉพาะ confirmed)
    $check = $conn->prepare("
        SELECT status FROM registrations
        WHERE event_id=? AND user_id=? AND status='confirmed'
    ");
    $check->bind_param("ii", $event_id, $user_id);
    $check->execute();
    $row = $check->get_result()->fetch_assoc();

    if ($row && $row['status'] === 'confirmed') {
        return "duplicate";
    }

    // ลบ pending เก่าถ้ามี (สร้างใหม่ทุกครั้ง)
    $del = $conn->prepare("DELETE FROM registrations WHERE event_id=? AND user_id=? AND status='pending'");
    $del->bind_param("ii", $event_id, $user_id);
    $del->execute();

    // Generate TOTP จาก algorithm (ไม่ต้องเก็บใน database)
    $otp = generateEventOTP($event_id, $user_id);

    // insert pending โดยไม่เก็บ otp_code และ otp_expire (ใช้ algorithm ตรวจสอบแทน)
    $stmt = $conn->prepare("
        INSERT INTO registrations (event_id, user_id, status)
        VALUES (?, ?, 'pending')
    ");

    if (!$stmt) {
        error_log("joinEvent prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("ii", $event_id, $user_id);

    if ($stmt->execute()) {
        error_log("joinEvent INSERT success: event=$event_id, user=$user_id, TOTP generated");
        return $otp; // ส่ง TOTP กลับ
    } else {
        error_log("joinEvent INSERT failed: " . $stmt->error);
        return false;
    }
}

function myEvent(): mysqli_result|bool
{
    if (!isset($_SESSION['user_id'])) return false;

    $conn = getConnection();

    $sql = "
        SELECT 
            e.*,
            COUNT(r.user_id) AS joined,
            MIN(img.img_path) AS image_path
        FROM event e
        LEFT JOIN registrations r ON r.event_id = e.event_id
        LEFT JOIN event_img img ON img.event_id = e.event_id
        WHERE e.user_id = ?
        GROUP BY e.event_id
        ORDER BY e.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();

    return $stmt->get_result();
}

function myRegEvent(): mysqli_result|bool
{
    if (!isset($_SESSION['user_id'])) return false;

    $conn = getConnection();

    $sql = "
        SELECT 
            e.*,
            r.status AS reg_status,
            COUNT(r2.user_id) AS joined,
            MIN(img.img_path) AS image_path
        FROM registrations r
        JOIN event e ON e.event_id = r.event_id
        LEFT JOIN registrations r2 ON r2.event_id = e.event_id
        LEFT JOIN event_img img ON img.event_id = e.event_id
        WHERE r.user_id = ?
        GROUP BY e.event_id, r.status
        ORDER BY e.start_date ASC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();

    return $stmt->get_result();
}

/* =========================
   ดึงคนที่ pending
========================= */
function getPendingUsers(int $event_id): mysqli_result|bool
{
    $conn = getConnection();

    $sql = "
        SELECT 
            u.user_id,
            u.full_name AS name,
            u.email,
            r.status
        FROM registrations r
        JOIN users u ON u.user_id = r.user_id
        WHERE r.event_id=? AND r.status='pending'
        ORDER BY r.create_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    return $stmt->get_result();
}

/* =========================
   ดึงคนที่ยืนยันแล้ว
========================= */
function getConfirmedUsers(int $event_id): mysqli_result|bool
{
    $conn = getConnection();

    $sql = "
        SELECT 
            u.user_id,
            u.full_name AS name,
            u.email,
            r.status,
            r.create_date
        FROM registrations r
        JOIN users u ON u.user_id = r.user_id
        WHERE r.event_id=? AND r.status='confirmed'
        ORDER BY r.create_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    return $stmt->get_result();
}

/* =========================
   ดึงคนที่ถูกปฏิเสธ
========================= */
function getRejectedUsers(int $event_id): mysqli_result|bool
{
    $conn = getConnection();

    $sql = "
        SELECT 
            u.user_id,
            u.full_name AS name,
            u.email,
            r.status,
            r.create_date
        FROM registrations r
        JOIN users u ON u.user_id = r.user_id
        WHERE r.event_id=? AND r.status='rejected'
        ORDER BY r.create_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    return $stmt->get_result();
}


/* =========================
   ตรวจ OTP - ใช้ TOTP Algorithm (ไม่ต้องเก็บใน database)
========================= */
function verifyOTP(int $event_id, string $otp): bool
{
    $conn = getConnection();
    
    // DEBUG: บันทึกค่าที่รับมา
    error_log("verifyOTP TOTP: event_id=$event_id, otp=$otp");
    
    // หา pending users ทั้งหมดใน event นี้
    $stmt = $conn->prepare("
        SELECT user_id FROM registrations
        WHERE event_id = ? AND status = 'pending'
    ");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // ตรวจสอบ OTP กับทุก user ที่ pending
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        
        // ใช้ TOTP algorithm ตรวจสอบ (ไม่ต้อง query database)
        if (verifyEventOTP($event_id, $user_id, $otp)) {
            error_log("verifyOTP TOTP: Valid OTP found for user_id=$user_id");
            
            // OTP ถูกต้อง → อัพเดท status เป็น confirmed
            $update = $conn->prepare("
                UPDATE registrations
                SET status='confirmed'
                WHERE event_id=? 
                  AND user_id=?
                  AND status='pending'
            ");
            $update->bind_param("ii", $event_id, $user_id);
            
            if ($update->execute() && $update->affected_rows > 0) {
                return true;
            }
        }
    }
    
    error_log("verifyOTP TOTP: No valid OTP found");
    return false;
}

function getAllEventsWithStatus(int $user_id): mysqli_result|bool
{
    $conn = getConnection();

    $sql = "
        SELECT 
            e.*,

            COUNT(CASE WHEN r.status='confirmed' THEN 1 END) AS joined,

            MIN(img.img_path) AS image_path,

            r2.status AS my_status

        FROM event e

        LEFT JOIN registrations r 
            ON r.event_id = e.event_id

        LEFT JOIN event_img img 
            ON img.event_id = e.event_id

        LEFT JOIN registrations r2
            ON r2.event_id = e.event_id
            AND r2.user_id = ?

        GROUP BY e.event_id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    return $stmt->get_result();
}

function getMyOTP(int $event_id, int $user_id): ?array
{
    // ตรวจสอบว่า user เป็น pending ใน event นี้หรือไม่
    $conn = getConnection();
    $stmt = $conn->prepare("
        SELECT status FROM registrations
        WHERE event_id = ? AND user_id = ? AND status = 'pending'
    ");
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result->fetch_assoc()) {
        return null; // ไม่พบ pending registration
    }
    
    // Generate TOTP จาก algorithm (ไม่ต้อง query database)
    $otp = generateEventOTP($event_id, $user_id);
    $remaining = getTOTPRemainingSeconds();
    
    // คำนวณ expire time
    $expire = date('Y-m-d H:i:s', time() + $remaining);
    
    return [
        'otp_code' => $otp,
        'otp_expire' => $expire,
        'remaining_seconds' => $remaining
    ];
}

/* =========================
   สถิติกิจกรรม (จำนวนคนตามสถานะ)
========================= */
function getEventStats(int $event_id): array
{
    $conn = getConnection();

    $sql = "
        SELECT 
            COUNT(CASE WHEN status='confirmed' THEN 1 END) AS confirmed_count,
            COUNT(CASE WHEN status='pending' THEN 1 END) AS pending_count,
            COUNT(CASE WHEN status='rejected' THEN 1 END) AS rejected_count,
            COUNT(*) AS total_count
        FROM registrations
        WHERE event_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc() ?: [
        'confirmed_count' => 0,
        'pending_count' => 0,
        'rejected_count' => 0,
        'total_count' => 0
    ];
}

/* =========================
   สถิติช่วงอายุผู้เข้าร่วม
========================= */
function getEventAgeStats(int $event_id): array
{
    $conn = getConnection();

    $sql = "
        SELECT 
            u.birth_date,
            TIMESTAMPDIFF(YEAR, u.birth_date, CURDATE()) AS age
        FROM registrations r
        JOIN users u ON u.user_id = r.user_id
        WHERE r.event_id = ? AND r.status = 'confirmed'
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $ageGroups = [
        'under_18' => 0,
        '18_25' => 0,
        '26_35' => 0,
        '36_50' => 0,
        'over_50' => 0
    ];

    while ($row = $result->fetch_assoc()) {
        $age = (int)$row['age'];
        if ($age < 18) {
            $ageGroups['under_18']++;
        } elseif ($age <= 25) {
            $ageGroups['18_25']++;
        } elseif ($age <= 35) {
            $ageGroups['26_35']++;
        } elseif ($age <= 50) {
            $ageGroups['36_50']++;
        } else {
            $ageGroups['over_50']++;
        }
    }

    return $ageGroups;
}

/* =========================
   ดูรายละเอียดกิจกรรม
========================= */
function getEventDetails(int $event_id): ?array
{
    $conn = getConnection();

    $sql = "
        SELECT 
            e.event_id,
            e.description,
            e.start_date,
            e.end_date,
            e.location,
            e.max_people,
            e.status,
            e.created_at,
            u.user_id AS creator_id,
            u.full_name AS creator_name,
            u.email AS creator_email,
            COUNT(CASE WHEN r.status='confirmed' THEN 1 END) AS joined
        FROM event e
        JOIN users u ON u.user_id = e.user_id
        LEFT JOIN registrations r ON r.event_id = e.event_id
        WHERE e.event_id = ?
        GROUP BY e.event_id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc() ?: null;
}

/* =========================
   แก้ไขกิจกรรม
========================= */
function updateEvent(int $event_id, string $desc, string $start, string $end, string $location, int $max_people, string $status): bool
{
    $conn = getConnection();

    $sql = "
        UPDATE event
        SET description = ?,
            start_date = ?,
            end_date = ?,
            location = ?,
            max_people = ?,
            status = ?
        WHERE event_id = ?
          AND user_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisii", $desc, $start, $end, $location, $max_people, $status, $event_id, $_SESSION['user_id']);

    return $stmt->execute() && $stmt->affected_rows > 0;
}

/* =========================
   ดึงข้อมูลกิจกรรมเดียว (สำหรับแก้ไข)
========================= */
function getEventById(int $event_id): ?array
{
    $conn = getConnection();

    $sql = "
        SELECT event_id, description, start_date, end_date, location, max_people, status
        FROM event
        WHERE event_id = ?
          AND user_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $event_id, $_SESSION['user_id']);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc() ?: null;
}

/* =========================
   ลบกิจกรรม
========================= */
function deleteEvent(int $event_id): bool
{
    $conn = getConnection();
    
    if (!isset($_SESSION['user_id'])) return false;

    // ลบ registrations ที่เกี่ยวข้องก่อน
    $delReg = $conn->prepare("DELETE FROM registrations WHERE event_id = ?");
    $delReg->bind_param("i", $event_id);
    $delReg->execute();
    
    // ลบรูปภาพที่เกี่ยวข้อง
    $delImg = $conn->prepare("DELETE FROM event_img WHERE event_id = ?");
    $delImg->bind_param("i", $event_id);
    $delImg->execute();
    
    // ลบกิจกรรม (เฉพาะของตัวเอง)
    $stmt = $conn->prepare("DELETE FROM event WHERE event_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $event_id, $_SESSION['user_id']);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

/* =========================
   ปฏิเสธการลงทะเบียน - ใช้ TOTP Algorithm (ไม่ต้องเก็บใน database)
========================= */
function rejectRegistration(int $event_id, string $otp): bool
{
    $conn = getConnection();
    
    // หา pending users ทั้งหมดใน event นี้
    $stmt = $conn->prepare("
        SELECT user_id FROM registrations
        WHERE event_id = ? AND status = 'pending'
    ");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // ตรวจสอบ OTP กับทุก user ที่ pending
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        
        // ใช้ TOTP algorithm ตรวจสอบ
        if (verifyEventOTP($event_id, $user_id, $otp)) {
            // OTP ถูกต้อง → อัพเดท status เป็น rejected
            $update = $conn->prepare("
                UPDATE registrations
                SET status = 'rejected'
                WHERE event_id = ? 
                  AND user_id = ?
                  AND status = 'pending'
            ");
            $update->bind_param("ii", $event_id, $user_id);
            $update->execute();

            if ($update->affected_rows > 0) {
                return true;
            }
        }
    }

    return false;
}

/* =========================
   ค้นหากิจกรรม (ชื่อ + ช่วงวัน)
========================= */
function searchEvents(string $keyword = '', string $start_date = '', string $end_date = ''): mysqli_result|bool
{
    $conn = getConnection();

    $sql = "
        SELECT 
            e.*,
            COUNT(CASE WHEN r.status='confirmed' THEN 1 END) AS joined,
            MIN(img.img_path) AS image_path
        FROM event e
        LEFT JOIN registrations r ON r.event_id = e.event_id
        LEFT JOIN event_img img ON img.event_id = e.event_id
        WHERE 1=1
    ";
    
    $params = [];
    $types = "";

    if (!empty($keyword)) {
        $sql .= " AND e.description LIKE ?";
        $params[] = "%$keyword%";
        $types .= "s";
    }

    if (!empty($start_date)) {
        $sql .= " AND e.start_date >= ?";
        $params[] = $start_date;
        $types .= "s";
    }

    if (!empty($end_date)) {
        $sql .= " AND e.end_date <= ?";
        $params[] = $end_date;
        $types .= "s";
    }

    $sql .= " GROUP BY e.event_id ORDER BY e.created_at DESC";

    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt->get_result();
}