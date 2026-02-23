<?php


function checkLogin(string $email, string $password): bool
{
    $conn = getConnection();
    $sql = "select password from users where email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['user_id'];
            return true;
        }
    }
    return false;
}

function getUsers(): mysqli_result|bool{
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
