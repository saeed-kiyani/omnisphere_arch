<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// =========================
// Get Form Data
// =========================

$id = (int)$_POST['id'];

$title = trim($_POST['title']);
$slug = trim($_POST['slug']);
$icon = trim($_POST['icon']);
$short_description = trim($_POST['short_description']);
$description = trim($_POST['description']);
$meta_title = trim($_POST['meta_title']);
$meta_description = trim($_POST['meta_description']);
$featured = isset($_POST['featured']) ? 1 : 0;
$status = $_POST['status'];

$old_thumbnail = $_POST['old_thumbnail'];

// =========================
// Validation
// =========================

if (empty($title) || empty($description)) {
    die("Title and Description are required.");
}

// =========================
// Duplicate Slug Check
// Ignore Current Record
// =========================

$check = $pdo->prepare("
SELECT id
FROM services
WHERE slug = ?
AND id != ?
");

$check->execute([$slug, $id]);

if ($check->rowCount() > 0) {

    die("Slug already exists.");

}

// =========================
// Image Upload
// =========================

$thumbnail = $old_thumbnail;

if (!empty($_FILES['thumbnail']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['thumbnail']['name'];
    $tmpName = $_FILES['thumbnail']['tmp_name'];
    $fileSize = $_FILES['thumbnail']['size'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {
        die("Only JPG, JPEG, PNG and WEBP allowed.");
    }

    if ($fileSize > 2 * 1024 * 1024) {
        die("Maximum image size is 2MB.");
    }

    $thumbnail = time() . "_" . uniqid() . "." . $extension;

    $uploadPath = "../../uploads/services/" . $thumbnail;

    if (move_uploaded_file($tmpName, $uploadPath)) {

        if (!empty($old_thumbnail)) {

            $oldPath = "../../uploads/services/" . $old_thumbnail;

            if (file_exists($oldPath)) {

                unlink($oldPath);

            }

        }

    }

}

// =========================
// Update Database
// =========================

$sql = "
UPDATE services SET

title=?,
slug=?,
icon=?,
thumbnail=?,
short_description=?,
description=?,
meta_title=?,
meta_description=?,
featured=?,
status=?

WHERE id=?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    $title,
    $slug,
    $icon,
    $thumbnail,
    $short_description,
    $description,
    $meta_title,
    $meta_description,
    $featured,
    $status,
    $id

]);

// =========================
// Redirect
// =========================

header("Location: index.php?success=updated");
exit;