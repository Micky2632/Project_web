
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

    if ($password !== $confirm) {
        echo "รหัสผ่านไม่ตรงกัน";
        return;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $role = "student";

    $sql = "INSERT INTO users
            (email, full_name, password, gender, birth_date, phone_number, role, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $email, $full_name, $password, $gender,
        $birth_date, $phone_number, $role
    );

    $stmt->execute();

    header("Location: /login");
}