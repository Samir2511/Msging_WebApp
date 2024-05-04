<?php

$allowed_ext = array("jpg" => "image/jpg",
    "jpeg" => "image/jpeg",
    "gif" => "image/gif",
    "png" => "image/png");
$file_name = $_FILES["image"]["name"];
$file_type = $_FILES["image"]["type"];
$file_size = $_FILES["image"]["size"];

$ext = pathinfo($file_name, PATHINFO_EXTENSION);

if (!array_key_exists($ext, $allowed_ext))
    die("Error: Please select a valid file format.");