<?php
include_once "../config.php";
class file_upload_manager
{
    public static function image_uploader($fileName)
    {
        // Check if the form was submitted
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // Check if file was uploaded without errors
            if (isset($_FILES[$fileName]) && $_FILES[$fileName]["error"] == 0)
            {
                $allowed_ext = array("jpg" => "image/jpg",
                    "jpeg" => "image/jpeg",
                    "gif" => "image/gif",
                    "png" => "image/png");
                $file_name = $_FILES[$fileName]["name"];
                $file_type = $_FILES[$fileName]["type"];
                $file_size = $_FILES[$fileName]["size"];

                // Verify file extension
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (!array_key_exists($ext, $allowed_ext))
                    die("Error: Please select a valid file format.");

                // Verify file size - 2MB max
                $maxsize = 5 * 1024 * 1024;

                if ($file_size > $maxsize)
                    die("Error: File size is larger than the allowed limit of 2MB");

                // Verify MYME type of the file
                if (in_array($file_type, $allowed_ext))
                {
                    // Check whether file exists before uploading it
                    if (file_exists("upload/".$_FILES[$fileName]["name"]))
                        echo $_FILES[$fileName]["name"]." already exists!";

                    else
                    {
                        move_uploaded_file($_FILES[$fileName]["tmp_name"],
                            "uploads/".$_FILES[$fileName]["name"]);
                        return $_FILES[$fileName]["name"];
                    }
                }
                else
                {
                    echo "Error: Please try again!";
                }
            }
            else
            {
                echo "Error: ". $_FILES[$fileName]["error"];
            }
        }
    }


}