
<?php
function register() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $conn = getConnection();

    $email        = $_POST['email'] ?? '';
    $full_name    = $_POST['full_name'] ?? '';
    $password     = $_POST['password'] ?? '';
    $confirm      = $_POST['confirm_password'] ?? '';
    $gender       = $_POST['gender'] ?? '';
    $birth_date   = $_POST['birth_date'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';

    // ✅ เช็ครหัสผ่านตรงกัน
     if ($password !== $confirm) {
        return "password_not_match";
    }

    // ✅ เช็ค email ซ้ำก่อน
    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
       return "duplicate";
    }

    // ✅ hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $role = "student";

    $sql = "INSERT INTO users
            (email, full_name, password, gender, birth_date, phone_number, role, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $email,
        $full_name,
        $passwordHash,
        $gender,
        $birth_date,
        $phone_number,
        $role
    );

    if ($stmt->execute()) {
        return true;
    }

    return false;
}