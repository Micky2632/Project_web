
<?php
function register(): bool|string {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return false;
    }

    $conn = getConnection();

    $email        = trim($_POST['email'] ?? '');
    $full_name    = trim($_POST['full_name'] ?? '');
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';
    $gender       = $_POST['gender'] ?? '';
    $birth_date   = $_POST['birth_date'] ?? '';
    $phone_number = trim($_POST['phone_number'] ?? '');

    // กัน input ว่าง
    if ($email === '' || $password === '') {
        return "invalid";
    }

    // เช็ครหัสผ่านตรงกัน
    if ($password !== $confirm) {
        return "password_not_match";
    }

    // เช็ค email ซ้ำ
    $check = $conn->prepare("SELECT 1 FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        return "duplicate";
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $role = "student";

    $stmt = $conn->prepare("
        INSERT INTO users
        (email, full_name, password, gender, birth_date, phone_number, role, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "sssssss",
        $email, $full_name, $passwordHash,
        $gender, $birth_date, $phone_number, $role
    );

    return $stmt->execute();
}