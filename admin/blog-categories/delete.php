<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){

    header("Location:index.php");
    exit;

}

$id=(int)$_GET['id'];

// Check if category exists
$stmt=$pdo->prepare("
SELECT id
FROM blog_categories
WHERE id=?
");

$stmt->execute([$id]);

if(!$stmt->fetch()){

    die("Category not found.");

}

// Optional: Remove category from blogs before deleting
$stmt=$pdo->prepare("
UPDATE blog
SET category_id=NULL
WHERE category_id=?
");

$stmt->execute([$id]);

// Delete category
$stmt=$pdo->prepare("
DELETE FROM blog_categories
WHERE id=?
");

$stmt->execute([$id]);

$_SESSION['success']="Category deleted successfully.";

header("Location:index.php");

exit;