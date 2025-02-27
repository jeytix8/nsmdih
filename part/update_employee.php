<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['name'], $_POST['section'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $section = $_POST['section'];
    
    // Check if an image was uploaded
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageInfo = getimagesize($imageTmpName); // Get image type

        if ($imageInfo === false) {
            die("Error: Uploaded file is not a valid image.");
        }

        // Identify image type and create image resource
        switch ($imageInfo['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imageTmpName);
                break;
            case 'image/png':
                $image = imagecreatefrompng($imageTmpName);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($imageTmpName);
                break;
            default:
                die("Error: Unsupported image format. Please upload JPEG, PNG, or WEBP.");
        }

        // Resize and crop to square (example: 200x200)
        $size = min(imagesx($image), imagesy($image)); // Get the smallest dimension
        $cropped = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
        $resized = imagescale($cropped, 200, 200);

        // Convert to base64 (for database storage)
        ob_start();
        imagejpeg($resized, null, 80); // Compress to 80% quality
        $imageData = base64_encode(ob_get_clean());

        imagedestroy($image);
        imagedestroy($cropped);
        imagedestroy($resized);

        // Update database with image
        $stmt = $conn->prepare("UPDATE employees SET name = ?, section = ?, image_data = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $section, $imageData, $id);
    } else {
        // If no new image, only update name & section
        $stmt = $conn->prepare("UPDATE employees SET name = ?, section = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $section, $id);
    }

    if ($stmt->execute()) {
        echo "Employee updated successfully.";
    } else {
        echo "Error updating employee.";
    }
} else {
    echo "Invalid input.";
}

$conn->close();

?>
