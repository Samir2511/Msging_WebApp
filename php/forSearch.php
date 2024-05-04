<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
function forSearch($user, $currentUser, $usersCount = 1) {
    global $conn;
    $output = "";
    if($usersCount == 1) {
        $lastMsgQ = $conn->prepare("SELECT msg FROM messages WHERE (sender_id = :currentUser_id OR receiver_id = :currentUser_id) AND (sender_id = :user_id OR receiver_id = :user_id) ORDER BY sent_at DESC LIMIT 1");
        $lastMsgQ->bindParam(':user_id', $user[0]['user_id'], PDO::PARAM_INT);
        $lastMsgQ->bindParam(':currentUser_id', $currentUser['user_id'], PDO::PARAM_INT);
        $lastMsgQ->execute();
        $lastMsg = $lastMsgQ->fetch(PDO::FETCH_ASSOC);
        $offline = $user[0]['status'];
        $output .= '
        <a href="chat.php?user_id=' . $user[0]['unique_id'] . '">
            <div class="content">
                <img src="php/uploads/' . $user[0]['img'] . ' " alt="">
                <div class="details">
                    <span>' . $user[0]['fname'] . " " . $user[0]['lname'] . '</span>
                    <p>' . ($lastMsg ? $lastMsg['msg'] : 'No messages available') .'</p>
                </div>
            </div>
            <div class="status-dot ' . $offline .'"><i class="fas fa-circle"></i></div>
        </a>';
    } else if ($usersCount > 1) {
        foreach ($user as $usr) {
            $lastMsgQ = $conn->prepare("SELECT msg FROM messages WHERE (sender_id = :currentUser_id OR receiver_id = :currentUser_id) AND (sender_id = :user_id OR receiver_id = :user_id) ORDER BY sent_at DESC LIMIT 1");
            $lastMsgQ->bindParam(':user_id', $usr['user_id'], PDO::PARAM_INT);
            $lastMsgQ->bindParam(':currentUser_id', $currentUser['user_id'], PDO::PARAM_INT);
            $lastMsgQ->execute();
            $lastMsg = $lastMsgQ->fetch(PDO::FETCH_ASSOC);
            $offline = $usr['status'];
            $output .= '
        <a href="chat.php?user_id=' . $usr['unique_id'] . '">
            <div class="content">
                <img src="php/uploads/' . $usr['img'] . ' " alt="">
                <div class="details">
                    <span>' . $usr['fname'] . " " . $usr['lname'] . '</span>
                    <p>' . ($lastMsg ? $lastMsg['msg'] : 'No messages available') .'</p>
                </div>
            </div>
            <div class="status-dot ' . $offline .'"><i class="fas fa-circle"></i></div>
        </a>';
        }
    }
    echo $output;
}