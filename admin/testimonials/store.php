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

    header("Location: create.php");
    exit;

}

if ($rating < 1 || $rating > 5) {

    $_SESSION['error'] = "Rating must be between 1 and 5.";

    header("Location: create.php");
    exit;

}

// ===========================
// Upload Profile Image
// ===========================

$profile_image = NULL;

if (!empty($_FILES['profile_image']['name'])) {

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $fileName  = $_FILES['profile_image']['name'];
    $tmpName   = $_FILES['profile_image']['tmp_name'];
    $fileSize  = $_FILES['profile_image']['size'];
    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {

        $_SESSION['error'] = "Invalid image format.";

        header("Location: create.php");
        exit;

    }

    if ($fileSize > 2 * 1024 * 1024) {

        $_SESSION['error'] = "Image must be less than 2MB.";

        header("Location: create.php");
        exit;

    }

    $profile_image = time() . "_" . uniqid() . "." . $extension;

    move_uploaded_file(
        $tmpName,
        "../../uploads/testimonials/" . $profile_image
    );

}

// ===========================
// Insert Testimonial
// ===========================

$sql = "
INSERT INTO testimonials
(
client_name,
designation,
company_name,
profile_image,
rating,
review,
featured,
display_order,
status
)
VALUES
(
?,?,?,?,?,?,?,?,?
)
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
    $status

]);

// ===========================
// Success
// ===========================

$_SESSION['success'] = "Testimonial added successfully.";

header("Location: index.php");
exit;