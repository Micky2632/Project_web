<?php


function checkLogin($email, $password)
{
    $conn = getConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $email = trim($email);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        return false;
    }
    if (password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getUsers(): mysqli_result|bool
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }
    $conn = getConnection();
    $sql = 'select * from users where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
