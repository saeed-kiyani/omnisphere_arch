<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// session_start();

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];


// ===========================
// Get Portfolio Details
// ===========================

$stmt = $pdo->prepare("
SELECT thumbnail
FROM portfolio
WHERE id = ?
");

$stmt->execute([$id]);

$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {

    die("Project not found.");

}


// ===========================
// Delete Thumbnail
// ===========================

if (
    !empty($project['thumbnail']) &&
    file_exists("../../uploads/portfolio/" . $project['thumbnail'])
) {

    unlink("../../uploads/portfolio/" . $project['thumbnail']);

}


// ===========================
// Delete Gallery Images
// ===========================

$stmt = $pdo->prepare("
SELECT image
FROM portfolio_images
WHERE portfolio_id = ?
");

$stmt->execute([$id]);

$gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($gallery as $img) {

    if (
        !empty($img['image']) &&
        file_exists("../../uploads/portfolio/" . $img['image'])
    ) {

        unlink("../../uploads/portfolio/" . $img['image']);

    }

}

// ===========================
// Delete Gallery Records
// ===========================

$stmt = $pdo->prepare("
DELETE FROM portfolio_images
WHERE portfolio_id = ?
");

$stmt->execute([$id]);

// ===========================
// Delete Portfolio
// ===========================

$stmt = $pdo->prepare("
DELETE FROM portfolio
WHERE id = ?
");

$stmt->execute([$id]);

// ===========================
// Success
// ===========================

$_SESSION['success'] = "Portfolio project deleted successfully.";

header("Location: index.php");
exit;