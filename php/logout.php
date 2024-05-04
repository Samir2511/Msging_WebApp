<?php
session_start();
if(isset($_SESSION['unique_id'])) {
    include_once '../config.php';
    $logout_id = $_GET['logout_id'];
        if(isset($logout_id)) {
            $status = "Offline";
            $stmt = $conn->prepare("UPDATE users SET status = :status WHERE unique_id = :logout_id");
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':logout_id', $logout_id, PDO::PARAM_INT);
            if($stmt->execute()) {
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
    } else {
        header("location: ../users.php");
    }
} else {
    header("location: ../login.php");
}