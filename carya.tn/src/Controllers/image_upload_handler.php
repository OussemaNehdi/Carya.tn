<?php 
function handleImageUpload($image, $dir) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
    $file_name = basename($image["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check file size
    if ($image["size"] > 1000000) {
        return "Error: File size exceeds the limit"; // File size exceeds the limit
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return "Error: Invalid file format"; // Invalid file format
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        return "Error: File already exists"; // File already exists
    }
    
    // Move uploaded file to destination directory
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        return "Error: Failed to move the file"; // Failed to move the file
    }

    return $file_name;
}
?>