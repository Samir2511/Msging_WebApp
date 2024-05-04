<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "../config.php";
include "userData.php";
include "forSearch.php";

$currentUser = userData::with_SessionUniqueId();

$outgoing_unique_id = $_SESSION['unique_id'];
$searchTerm = '%' . $_POST['searchTerm'] . '%';
$sql = "SELECT * FROM users WHERE unique_id <> :outgoing_id AND (fname LIKE :searchTerm OR lname LIKE :searchTerm)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':outgoing_id', $outgoing_unique_id, PDO::PARAM_INT);
$stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
$stmt->execute();


$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "";
if (count($users) > 0) {
    if(count($users) == 1) {
        forSearch($users, $currentUser);
    } else if(count($users) > 1) {
        forSearch($users, $currentUser, count($users));
    }
} else {
    $output .= 'No user found related to your search.';
}

echo $output;


