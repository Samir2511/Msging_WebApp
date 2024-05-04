<?php

//include_once "../config.php";


class userData
{
    public static function with_SessionUniqueId()  {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id = '{$_SESSION['unique_id']}'");
        $stmt->execute();
        if($stmt->rowCount() > 0)
            $userData = $stmt->fetch();
        return $userData;
    }

    public static function with_GET_UniqueId($GET_UniqueId)  {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id = '{$GET_UniqueId}'");
        $stmt->execute();
        if($stmt->rowCount() > 0)
            $userData = $stmt->fetch();
        return $userData;
    }

    public static function all_Other_Users($loggedIn_UserUnique_Id) {
        try {
            global $conn;
            $stmt = $conn->prepare("SELECT * FROM users WHERE unique_id <> :unique_id ORDER BY user_id DESC");
            $stmt->bindParam(':unique_id', $loggedIn_UserUnique_Id, PDO::PARAM_STR);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            // Handle any PDO exceptions
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}