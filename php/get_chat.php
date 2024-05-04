<?php
session_start();
include_once '../config.php';
include 'userData.php';

$currentUser = userData::with_SessionUniqueId();
$otherUser = userData::with_GET_UniqueId($_POST['other_user_id']);
$currentUser_id = $currentUser['user_id'];
$otherUser_id = $otherUser['user_id'];
$otherUser_Name = userData::with_GET_UniqueId($_POST['other_user_id'])['fname'].userData::with_GET_UniqueId($_POST['other_user_id'])['lname'];



$you = $conn->prepare("SELECT * FROM messages WHERE sender_id = :sender_id AND receiver_id = :receiver_id ORDER BY sent_at ASC");
$you->bindParam(':sender_id', $currentUser_id, PDO::PARAM_INT);
$you->bindParam(':receiver_id', $otherUser_id, PDO::PARAM_INT);
$you->execute();
$other = $conn->prepare("SELECT * FROM messages WHERE sender_id = :receiver_id AND receiver_id = :sender_id ORDER BY sent_at ASC");
$other->bindParam(':sender_id', $currentUser_id, PDO::PARAM_INT);
$other->bindParam(':receiver_id', $otherUser_id, PDO::PARAM_INT);
$other->execute();



$messages = array();
$output = "";

while ($rowYou = $you->fetch(PDO::FETCH_ASSOC)) {
    $messages[] = array(
        'sender' => 'You',
        'message' => $rowYou['msg'],
        'sent_at' => $rowYou['sent_at']
    );
}

while ($rowOther = $other->fetch(PDO::FETCH_ASSOC)) {
    $messages[] = array(
        'sender' => $otherUser_Name,
        'message' => $rowOther['msg'],
        'sent_at' => $rowOther['sent_at']
    );
}

usort($messages, function($a, $b) {
    return strtotime($a['sent_at']) - strtotime($b['sent_at']);
});



if (empty($messages)) {
    $output .= '<div class="text">No messages are available. Once you send a message, it will appear here.</div>';
} else {
    
    foreach ($messages as $message) {
        if ($message['sender'] == "You") {
            $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $message['message'] .'</p>
                                </div>
                            </div>';
        } else if ($message['sender'] == $otherUser_Name) {
            $output .= '<div class="chat incoming">
                                <img src="php/uploads/'. $otherUser['img'] .'" alt="">
                                <div class="details">
                                    <p>'. $message['message'] .'</p>
                                </div>
                            </div>';
        }
    }
}

echo $output;