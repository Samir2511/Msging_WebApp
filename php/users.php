<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "../config.php";
include_once "userData.php";


$users = userData::all_Other_Users($_SESSION['unique_id']);
$currentUser = userData::with_SessionUniqueId();

$output = "";
if(empty($users)) {
    echo $output .= "No users are available to chat";
}

foreach ($users as $user) {
    $lastMsgQ = $conn->prepare("SELECT msg FROM messages WHERE (sender_id = :currentUser_id OR receiver_id = :currentUser_id) AND (sender_id = :user_id OR receiver_id = :user_id) ORDER BY sent_at DESC LIMIT 1");
    $lastMsgQ->bindParam(':user_id', $user['user_id'], PDO::PARAM_INT);
    $lastMsgQ->bindParam(':currentUser_id', $currentUser['user_id'], PDO::PARAM_INT);
    $lastMsgQ->execute();
    $lastMsg = $lastMsgQ->fetch(PDO::FETCH_ASSOC);
    $offline = $user['status'];
    $output .= '
        <a href="chat.php?user_id=' . $user['unique_id'] . '">
            <div class="content">
                <img src="php/uploads/' . $user['img'] . ' " alt="">
                <div class="details">
                    <span>' . $user['fname'] . " " . $user['lname'] . '</span>
                    <p>' . ($lastMsg ? $lastMsg['msg'] : 'No messages available') .'</p>
                </div>
            </div>
            <div class="status-dot ' . $offline .'"><i class="fas fa-circle"></i></div>
        </a>';
}
echo $output;