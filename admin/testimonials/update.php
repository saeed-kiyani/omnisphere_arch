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
// Validate ID
// ===========================

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {

    $_SESSION['error'] = "Invalid testimonial.";

    header("Location: index.php");
    exit;

}

$id = (int) $_POST['id'];

// ===========================
// Get Existing Testimonial
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
// Get Form Data
// ===========================

$client_name    = trim($_POST['client_name']);
$designation    = trim($_POST['designation']);
$company_name   = trim($_POST['company_name']);
$rating         = (int) $_POST['rating'];
$review         = trim($_POST['review']);
$featured = isset($_POST['featured'])
    ? (int) $_POST['featured']
    : 0;
$display_order  = (int) $_POST['display_order'];
$status         = trim($_POST['status']);

// ===========================
// Validation
// ===========================

if (empty($client_name) || empty($review)) {

    $_SESSION['error'] = "Please fill all required fields.";

    header("Location: edit.php?id=".$id);
    exit;

}

if ($rating < 1 || $rating > 5) {

    $_SESSION['error'] = "Rating must be between 1 and 5.";

    header("Location: edit.php?id=".$id);
    exit;

}

// ===========================
// Upload New Image
// ===========================

$profile_image = $testimonial['profile_image'];

if (!empty($_FILES['profile_image']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['profile_image']['name'];
    $tmpName = $_FILES['profile_image']['tmp_name'];
    $fileSize = $_FILES['profile_image']['size'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {

        $_SESSION['error'] = "Invalid image format.";

        header("Location: edit.php?id=".$id);
        exit;

    }

    if ($fileSize > 2 * 1024 * 1024) {

        $_SESSION['error'] = "Image must be below 2 MB.";

        header("Location: edit.php?id=".$id);
        exit;

    }

    $profile_image = time() . "_" . uniqid() . "." . $extension;

    move_uploaded_file(
        $tmpName,
        "../../uploads/testimonials/" . $profile_image
    );

    // Delete Old Image

    if (
        !empty($testimonial['profile_image']) &&
        file_exists("../../uploads/testimonials/" . $testimonial['profile_image'])
    ) {

        unlink("../../uploads/testimonials/" . $testimonial['profile_image']);

    }

}

// ===========================
// Update Testimonial
// ===========================

$sql = "
UPDATE testimonials
SET
client_name=?,
designation=?,
company_name=?,
profile_image=?,
rating=?,
review=?,
featured=?,
display_order=?,
status=?
WHERE id=?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    $client_name,
    $designation,
    $company_name,
    $profile_image,
    $rating,
    $review,
    $featured,
    $display_order,
    $status,
    $id

]);

// ===========================
// Success
// ===========================

$_SESSION['success'] = "Testimonial updated successfully.";

header("Location: index.php");
exit;