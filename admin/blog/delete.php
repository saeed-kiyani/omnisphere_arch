<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int)$_GET['id'];


// ===========================
// Fetch Blog
// ===========================

$stmt = $pdo->prepare("
SELECT thumbnail
FROM blog
WHERE id = ?
");

$stmt->execute([$id]);

$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {

    die("Blog not found.");

}


// ===========================
// Delete Thumbnail
// ===========================

if (

    !empty($blog['thumbnail']) &&

    file_exists("../../uploads/blog/" . $blog['thumbnail'])

) {

    unlink("../../uploads/blog/" . $blog['thumbnail']);

}


// ===========================
// Delete Blog
// ===========================

$stmt = $pdo->prepare("
DELETE FROM blog
WHERE id = ?
");

$stmt->execute([$id]);


// ===========================
// Success
// ===========================

$_SESSION['success'] = "Blog deleted successfully.";

header("Location: index.php");
exit;