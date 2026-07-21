<?php
require_once 'includes/config.php';
requireLogin();

header('Content-Type: application/json');

try {
    if (empty($_FILES['file']['name']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('No image uploaded.');
    }

    $allowed = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp'
    ];

    $tmp  = $_FILES['file']['tmp_name'];
    $ext  = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($tmp);

    if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) {
        throw new RuntimeException('Only JPG, PNG and WEBP images are allowed.');
    }

    if ($_FILES['file']['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Image must be smaller than 5MB.');
    }

    // Images folder
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/Blogs';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }

    $filename = 'editor-' . time() . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    $target   = $upload_dir . '/' . $filename;

    if (!move_uploaded_file($tmp, $target)) {
        throw new RuntimeException('Unable to save image.');
    }

    echo json_encode([
        'location' => 'https://drmanishagupta.in/images/Blogs/' . $filename
    ]);

} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}

// require_once 'includes/config.php';
// requireLogin();

// header('Content-Type: application/json');

// try {
//     if (empty($_FILES['file']['name']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
//         throw new RuntimeException('No image uploaded.');
//     }

//     $allowed = [
//         'jpg' => 'image/jpeg',
//         'jpeg' => 'image/jpeg',
//         'png' => 'image/png',
//         'webp' => 'image/webp'
//     ];

//     $tmp = $_FILES['file']['tmp_name'];
//     $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
//     $mime = mime_content_type($tmp);

//     if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) {
//         throw new RuntimeException('Only JPG, PNG, and WEBP images are allowed.');
//     }

//     if ($_FILES['file']['size'] > 5 * 1024 * 1024) {
//         throw new RuntimeException('Image must be smaller than 5MB.');
//     }

//     $upload_dir = __DIR__ . '/../drmanishagupta/uploads/blogs';
//     if (!is_dir($upload_dir)) {
//         mkdir($upload_dir, 0775, true);
//     }

//     $filename = 'editor-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
//     $target = $upload_dir . '/' . $filename;

//     if (!move_uploaded_file($tmp, $target)) {
//         throw new RuntimeException('Unable to save image.');
//     }

//     echo json_encode([
//         'location' => '/drmanishagupta/images/Blogs/' . $filename
//     ]);
// } catch (Throwable $e) {
//     http_response_code(400);
//     echo json_encode(['error' => $e->getMessage()]);
// }



