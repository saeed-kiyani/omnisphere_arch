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

// ===========================
// Get Form Data
// ===========================

$category_id = (int)$_POST['category_id'];

$title = trim($_POST['title']);

$slug = trim($_POST['slug']);

$short_description = trim($_POST['short_description']);

$content = trim($_POST['content']);

$author = trim($_POST['author']);

$meta_title = trim($_POST['meta_title']);

$meta_description = trim($_POST['meta_description']);

$featured = isset($_POST['featured']) ? 1 : 0;

$status = trim($_POST['status']);


// ===========================
// Validation
// ===========================

if (

empty($category_id) ||

empty($title) ||

empty($slug) ||

empty($content)

) {

    die("Please fill all required fields.");

}


// ===========================
// Duplicate Slug Check
// ===========================

$check = $pdo->prepare("
SELECT id
FROM blog
WHERE slug = ?
");

$check->execute([$slug]);

if ($check->rowCount() > 0) {

    die("Slug already exists.");

}


// ===========================
// Upload Thumbnail
// ===========================

$thumbnail = NULL;

if (!empty($_FILES['thumbnail']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['thumbnail']['name'];

    $tmpName = $_FILES['thumbnail']['tmp_name'];

    $fileSize = $_FILES['thumbnail']['size'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {

        die("Invalid image format.");

    }

    if ($fileSize > 2 * 1024 * 1024) {

        die("Image must be smaller than 2MB.");

    }

    $thumbnail = time() . "_" . uniqid() . "." . $extension;

    move_uploaded_file(

        $tmpName,

        "../../uploads/blog/" . $thumbnail

    );

}


// ===========================
// Insert Blog
// ===========================

$sql = "

INSERT INTO blog
(

category_id,

title,
slug,
thumbnail,
short_description,
content,
meta_title,
meta_description,
author,
featured,
views,
status

)

VALUES
(

?,?,?,?,?,?,?,?,?,?,?,?

)

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

$category_id,

$title,

$slug,

$thumbnail,

$short_description,

$content,

$meta_title,

$meta_description,

$author,

$featured,

0,

$status

]);


// ===========================
// Success
// ===========================

$_SESSION['success'] = "Blog post created successfully.";

header("Location: index.php");

exit;