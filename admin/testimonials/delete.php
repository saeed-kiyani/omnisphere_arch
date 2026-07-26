<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    $_SESSION['error'] = "Invalid testimonial.";

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

// ===========================
// Get Testimonial
// ===========================

$stmt = $pdo->prepare("
SELECT profile_image
FROM testimonials
WHERE id = ?
LIMIT 1
");

$stmt->execute([$id]);

$testimonial = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$testimonial) {

    $_SESSION['error'] = "Testimonial not found.";

    header("Location: index.php");
    exit;

}

// ===========================
// Delete Profile Image
// ===========================

if (
    !empty($testimonial['profile_image']) &&
    file_exists("../../uploads/testimonials/" . $testimonial['profile_image'])
) {

    unlink("../../uploads/testimonials/" . $testimonial['profile_image']);

}

// ===========================
// Delete Testimonial
// ===========================

$stmt = $pdo->prepare("
DELETE FROM testimonials
WHERE id = ?
");

$stmt->execute([$id]);

// ===========================
// Success
// ===========================

$_SESSION['success'] = "Testimonial deleted successfully.";

header("Location: index.php");
exit;