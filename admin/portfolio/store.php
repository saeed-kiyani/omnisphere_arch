<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// ======================
// Get Form Data
// ======================

$service_id = (int)$_POST['service_id'];

$title = trim($_POST['title']);

$slug = trim($_POST['slug']);

$client_name = trim($_POST['client_name']);

$location = trim($_POST['location']);

$project_year = $_POST['project_year'];

$project_area = trim($_POST['project_area']);

$project_status = $_POST['project_status'];

$short_description = trim($_POST['short_description']);

$description = trim($_POST['description']);

$meta_title = trim($_POST['meta_title']);

$meta_description = trim($_POST['meta_description']);

$featured = isset($_POST['featured']) ? 1 : 0;

$status = $_POST['status'];

// ======================
// Validation
// ======================

if (
    empty($service_id) ||
    empty($title) ||
    empty($description)
) {

    die("Please fill all required fields.");

}

$check = $pdo->prepare("
SELECT id
FROM portfolio
WHERE slug=?
");

$check->execute([$slug]);

if ($check->rowCount() > 0) {
    die("Slug already exists.");
}

$thumbnail = NULL;

if (!empty($_FILES['thumbnail']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['thumbnail']['name'];

    $tmpName = $_FILES['thumbnail']['tmp_name'];

    $fileSize = $_FILES['thumbnail']['size'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if(!in_array($extension,$allowed)){

        die("Invalid thumbnail image.");

    }

    if($fileSize > 2*1024*1024){

        die("Thumbnail must be below 2 MB.");

    }

    $thumbnail = time() . "_" . uniqid() . "." . $extension;

    move_uploaded_file(
        $tmpName,
        "../../uploads/portfolio/" . $thumbnail
    );

}

$sql = "
INSERT INTO portfolio
(
service_id,
title,
slug,
client_name,
location,
project_year,
project_area,
project_status,
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
?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
)
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
    $status

]);

$portfolio_id = $pdo->lastInsertId();

$_SESSION['success'] = "Portfolio project created successfully.";

header("Location: index.php");
exit;