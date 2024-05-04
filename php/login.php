<?php

session_start();
include_once '../config.php';

$email = $_POST['email'];
$pass = $_POST['password'];
$response = array();

if(!empty($email) && !empty($pass)) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = '{$email}'");
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            $encpswd = md5($pass);
            $userPass_FromDB = $user['password'];
            if($encpswd == $userPass_FromDB) {
                $status = "Online";
                $usrStatusUpdate = $conn->prepare("UPDATE users SET status = '{$status}' WHERE unique_id = {$user['unique_id']}");
                if($usrStatusUpdate->execute()) {
                    $_SESSION['unique_id'] = $user['unique_id'];
                    $response['status'] = "success";
                    $response['message'] = "Logged in successfully!";
                } else {
                    $response['status'] = "error";
                    $response['message'] = "Error Updating User Status!";
                }

            } else {
                $response['status'] = "error";
                $response['message'] = "Password is incorrect!";
            }
        } else {
            $response['status'] = "error";
            $response['message'] = "Email or Password is incorrect!";
        }
    } else {
        $response['status'] = "error";
        $response['message'] = "Filtering went wrong!";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Enter your Email & Password!";
}
header('Content-Type: application/json');
echo json_encode($response);
?>
