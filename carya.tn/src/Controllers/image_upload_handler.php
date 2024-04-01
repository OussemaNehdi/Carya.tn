<?php 
function handleImageUpload($image, $dir) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
    $file_name = basename($image["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check file size
    if ($image["size"] > 1000000) {
        return "message= File size exceeds the limit&type=error"; // File size exceeds the limit
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return "message= Invalid file format&type=error"; // Invalid file format
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        return "message= File already exists&type=error"; // File already exists
    }
    
    // Move uploaded file to destination directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        return "message= Failed to move the file&type=error"; // Failed to move the file
    }

    return $file_name;
}
?>