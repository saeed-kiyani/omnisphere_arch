<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// ===========================
// Get Form Data
// ===========================

$id = (int)$_POST['id'];

$service_id = (int)$_POST['service_id'];

$title = trim($_POST['title']);

$slug = trim($_POST['slug']);

$client_name = trim($_POST['client_name']);

$location = trim($_POST['location']);

$project_year = trim($_POST['project_year']);

$project_area = trim($_POST['project_area']);

$project_status = trim($_POST['project_status']);

$short_description = trim($_POST['short_description']);

$description = trim($_POST['description']);

$meta_title = trim($_POST['meta_title']);

$meta_description = trim($_POST['meta_description']);

$featured = isset($_POST['featured']) ? 1 : 0;

$status = trim($_POST['status']);


// ===========================
// Validation
// ===========================

if (
    empty($service_id) ||
    empty($title) ||
    empty($description)
) {
    die("Please fill all required fields.");
}


// ===========================
// Duplicate Slug Check
// ===========================

$check = $pdo->prepare("
SELECT id
FROM portfolio
WHERE slug = ?
AND id != ?
");

$check->execute([$slug, $id]);

if ($check->rowCount() > 0) {

    die("Slug already exists.");

}


// ===========================
// Get Current Thumbnail
// ===========================

$stmt = $pdo->prepare("
SELECT thumbnail
FROM portfolio
WHERE id = ?
");

$stmt->execute([$id]);

$current = $stmt->fetch(PDO::FETCH_ASSOC);

$thumbnail = $current['thumbnail'];


// ===========================
// Upload New Thumbnail
// ===========================

if (!empty($_FILES['thumbnail']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $extension = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {

        die("Invalid thumbnail.");

    }

    if ($_FILES['thumbnail']['size'] > 2 * 1024 * 1024) {

        die("Thumbnail must be below 2MB.");

    }

    // Delete old image

    if (
        !empty($thumbnail) &&
        file_exists("../../uploads/portfolio/" . $thumbnail)
    ) {

        unlink("../../uploads/portfolio/" . $thumbnail);

    }

    $thumbnail = time() . "_" . uniqid() . "." . $extension;

    move_uploaded_file(

        $_FILES['thumbnail']['tmp_name'],

        "../../uploads/portfolio/" . $thumbnail

    );

}


// ===========================
// Update Project
// ===========================

$sql = "

UPDATE portfolio SET

service_id=?,
title=?,
slug=?,
client_name=?,
location=?,
project_year=?,
project_area=?,
project_status=?,
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

$service_id,

$title,

$slug,

$client_name,

$location,

$project_year,

$project_area,

$project_status,

$thumbnail,

$short_description,

$description,

$meta_title,

$meta_description,

$featured,

$status,

$id

]);

$_SESSION['success'] = "Portfolio project updated successfully.";

header("Location: index.php");

exit;