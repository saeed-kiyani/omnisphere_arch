<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Only Allow POST
// ===========================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");
    exit;

}

// ===========================
// Get Form Data
// ===========================

$title = trim($_POST['title']);

$slug = trim($_POST['slug']);

$meta_title = trim($_POST['meta_title']);

$meta_description = trim($_POST['meta_description']);

$display_order = (int)$_POST['display_order'];

$status = trim($_POST['status']);


// ===========================
// Validation
// ===========================

if (

    empty($title) ||

    empty($slug)

){

    die("Please fill all required fields.");

}


// ===========================
// Duplicate Slug Check
// ===========================

$check = $pdo->prepare("
SELECT id
FROM blog_categories
WHERE slug = ?
");

$check->execute([$slug]);

if($check->rowCount() > 0){

    die("Slug already exists.");

}


// ===========================
// Insert Category
// ===========================

$sql = "

INSERT INTO blog_categories
(

title,
slug,
meta_title,
meta_description,
display_order,
status

)

VALUES
(

?,?,?,?,?,?

)

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

$title,

$slug,

$meta_title,

$meta_description,

$display_order,

$status

]);


// ===========================
// Success
// ===========================

$_SESSION['success'] = "Blog category created successfully.";

header("Location: index.php");

exit;