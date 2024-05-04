<?php
include_once "../config.php";
include_once "userData.php";

session_start();
$currentUser = userData::with_SessionUniqueId();



$timezone = new DateTimeZone('Egypt');
$currentDateTime = new DateTime('now', $timezone);
$msg_sent_at = $currentDateTime->format('Y-m-d H:i:s');

$otherUser = userData::with_GET_UniqueId($_POST['other_user']);
$message = $_POST['message'];


$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, msg, sent_at)
VALUES (:sender_id, :receiver_id, :msg, :sent_at)");

$stmt->bindParam(':sender_id', $currentUser['user_id'], PDO::PARAM_INT);
$stmt->bindParam(':receiver_id', $otherUser['user_id'], PDO::PARAM_INT);
$stmt->bindParam(':msg', $message, PDO::PARAM_STR);
$stmt->bindParam(':sent_at', $msg_sent_at, PDO::PARAM_STR);
$stmt->execute();

