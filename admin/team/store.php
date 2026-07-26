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

$full_name      = trim($_POST['full_name']);
$designation    = trim($_POST['designation']);
$bio            = trim($_POST['bio']);
$email          = trim($_POST['email']);
$phone          = trim($_POST['phone']);
$linkedin       = trim($_POST['linkedin']);
$facebook       = trim($_POST['facebook']);
$instagram      = trim($_POST['instagram']);
$display_order  = (int)$_POST['display_order'];
$status         = trim($_POST['status']);

// ===========================
// Validation
// ===========================

if (
    empty($full_name) ||
    empty($designation)
) {

    die("Please fill all required fields.");

}

// ===========================
// Upload Profile Image
// ===========================

$profile_image = NULL;

if (!empty($_FILES['profile_image']['name'])) {

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['profile_image']['name'];

    $tmpName = $_FILES['profile_image']['tmp_name'];

    $fileSize = $_FILES['profile_image']['size'];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {

        die("Invalid image format.");

    }

    if ($fileSize > 2 * 1024 * 1024) {

        die("Image must be below 2 MB.");

    }

    $profile_image = time() . "_" . uniqid() . "." . $extension;

    move_uploaded_file(
        $tmpName,
        "../../uploads/team/" . $profile_image
    );

}

// ===========================
// Insert Team Member
// ===========================

$sql = "
INSERT INTO team
(
full_name,
designation,
profile_image,
bio,
email,
phone,
linkedin,
facebook,
instagram,
display_order,
status
)
VALUES
(
?,?,?,?,?,?,?,?,?,?,?
)
";

$status = trim($_POST['status']);

$stmt = $pdo->prepare($sql);

$stmt->execute([

$full_name,

$designation,

$profile_image,

$bio,

$email,

$phone,

$linkedin,

$facebook,

$instagram,

$display_order,

$status

]);

// ===========================
// Success
// ===========================

$_SESSION['success'] = "Team member added successfully.";

header("Location: index.php");
exit;