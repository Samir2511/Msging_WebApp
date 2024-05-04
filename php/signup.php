<?php
session_start();
include_once "../config.php";
include("file_upload_manager.php");


$response = array();
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$passwd = $_POST['password'];
$email = $_POST['email'];

if(!empty($fname) && !empty($lname) && !empty($passwd) && !empty($email)) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailCheckInDB = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $emailCheckInDB->bindParam(':email', $email, PDO::PARAM_STR);
        $emailCheckInDB->execute();
        if($emailCheckInDB->rowCount() > 0) {
            $response['status'] = "error";
            $response['message'] = "Email already exists!";
        }
        else {

            $ran_id = rand(time(), 100000000);
            $status = "Online";
            $encrypt_pass = md5($passwd);
            $image_name = file_upload_manager::image_uploader("image");
            $stmt = $conn->prepare("INSERT INTO users (unique_id, fname, lname, email, password, img ,status) 
            VALUES ('{$ran_id}' , :fname, :lname, :email, :password, '{$image_name}' ,'{$status}')");

            // Bind the user input to the prepared statement
            $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $lname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $encrypt_pass, PDO::PARAM_STR);
            if($stmt->execute()) {
                $response['status'] = "success";
                $response['message'] = "Signed up successfully!";
                $sqlstmt2 = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $sqlstmt2->bindParam(':email', $email, PDO::PARAM_STR);
                $sqlstmt2->execute();
                if($sqlstmt2->rowCount() > 0) {
                    $res = $sqlstmt2->fetch();
                    $_SESSION['unique_id'] = $res['unique_id'];
                } else {
                    $response['status'] = "error";
                    $response['message'] = "Email doesn't exist!";
                }
            } else {
                $response['status'] = "error";
                $response['message'] = "Sign up failed!";
            }
        }

    } else {
        $response['status'] = "error";
        $response['message'] = "Invalid email format!";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "All input fields are required!";
}

header('Content-Type: application/json');
echo json_encode($response);