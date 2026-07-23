<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

// ===========================
// Get Form Data
// ===========================

$title = trim($_POST['title']);
$slug = trim($_POST['slug']);
$icon = trim($_POST['icon']);
$short_description = trim($_POST['short_description']);
$description = trim($_POST['description']);
$meta_title = trim($_POST['meta_title']);
$meta_description = trim($_POST['meta_description']);
$featured = isset($_POST['featured']) ? 1 : 0;
$status = $_POST['status'];

// ===========================
// Validation
// ===========================

if (empty($title) || empty($description)) {
    die("Title and Description are required.");
}

// ===========================
// Check Duplicate Slug
// ===========================

$check = $pdo->prepare("SELECT id FROM services WHERE slug = ?");
$check->execute([$slug]);

if ($check->rowCount() > 0) {
    die("Slug already exists. Please use another title.");
}

// ===========================
// Image Upload
// ===========================

$thumbnail = NULL;

if (!empty($_FILES['thumbnail']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['thumbnail']['name'];
    $tmpName  = $_FILES['thumbnail']['tmp_name'];
    $fileSize = $_FILES['thumbnail']['size'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {
        die("Invalid image format.");
    }

    if ($fileSize > 2 * 1024 * 1024) {
        die("Image size must be less than 2MB.");
    }

    $thumbnail = time() . "_" . uniqid() . "." . $extension;

    $uploadPath = "../../uploads/services/" . $thumbnail;

    move_uploaded_file($tmpName, $uploadPath);
}

// ===========================
// Insert Into Database
// ===========================

$sql = "INSERT INTO services
(
title,
slug,
icon,
thumbnail,
short_description,
description,
meta_title,
meta_description,
featured,
status
)

VALUES
(
?,
?,
?,
?,
?,
?,
?,
?,
?,
?
)";

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
    $status
]);

// ===========================
// Redirect
// ===========================

header("Location: index.php?success=created");
exit;