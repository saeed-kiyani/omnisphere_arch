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

$id                    = (int) $_POST['id'];

$company_name          = trim($_POST['company_name']);
$tagline               = trim($_POST['tagline']);
$email                 = trim($_POST['email']);
$phone                 = trim($_POST['phone']);
$whatsapp              = trim($_POST['whatsapp']);
$address               = trim($_POST['address']);

$google_map_iframe     = trim($_POST['google_map_iframe']);

$facebook              = trim($_POST['facebook']);
$instagram             = trim($_POST['instagram']);
$linkedin              = trim($_POST['linkedin']);
$youtube               = trim($_POST['youtube']);

$meta_title            = trim($_POST['meta_title']);
$meta_description      = trim($_POST['meta_description']);
$meta_keywords         = trim($_POST['meta_keywords']);

$google_analytics_id   = trim($_POST['google_analytics_id']);
$meta_pixel_id         = trim($_POST['meta_pixel_id']);

$footer_text           = trim($_POST['footer_text']);

// ===========================
// Validation
// ===========================

if (empty($company_name)) {

    $_SESSION['error'] = "Company name is required.";

    header("Location: index.php");
    exit;

}

// ===========================
// Fetch Existing Files
// ===========================

$stmt = $pdo->prepare("
SELECT logo,favicon
FROM website_settings
WHERE id = ?
");

$stmt->execute([$id]);

$current = $stmt->fetch(PDO::FETCH_ASSOC);

$logo = $current['logo'];
$favicon = $current['favicon'];

// ===========================
// Upload Folder
// ===========================

$uploadPath = "../../uploads/settings/";

// ===========================
// Upload Logo
// ===========================

if (!empty($_FILES['logo']['name'])) {

    $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp','svg'];

    if (!in_array($ext,$allowed)) {

        die("Invalid logo format.");

    }

    $newLogo = time().'_logo.'.$ext;

    move_uploaded_file(
        $_FILES['logo']['tmp_name'],
        $uploadPath.$newLogo
    );

    if (
        !empty($logo) &&
        file_exists($uploadPath.$logo)
    ) {

        unlink($uploadPath.$logo);

    }

    $logo = $newLogo;

}

// ===========================
// Upload Favicon
// ===========================

if (!empty($_FILES['favicon']['name'])) {

    $ext = strtolower(pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION));

    $allowed = ['ico','png','jpg','jpeg','webp'];

    if (!in_array($ext,$allowed)) {

        die("Invalid favicon format.");

    }

    $newFavicon = time().'_favicon.'.$ext;

    move_uploaded_file(
        $_FILES['favicon']['tmp_name'],
        $uploadPath.$newFavicon
    );

    if (
        !empty($favicon) &&
        file_exists($uploadPath.$favicon)
    ) {

        unlink($uploadPath.$favicon);

    }

    $favicon = $newFavicon;

}

// ===========================
// Update Database
// ===========================

$sql = "

UPDATE website_settings

SET

company_name=?,
tagline=?,
logo=?,
favicon=?,
email=?,
phone=?,
whatsapp=?,
address=?,
google_map_iframe=?,
facebook=?,
instagram=?,
linkedin=?,
youtube=?,
meta_title=?,
meta_description=?,
meta_keywords=?,
google_analytics_id=?,
meta_pixel_id=?,
footer_text=?,
updated_at=NOW()

WHERE id=?

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

$company_name,
$tagline,
$logo,
$favicon,
$email,
$phone,
$whatsapp,
$address,
$google_map_iframe,
$facebook,
$instagram,
$linkedin,
$youtube,
$meta_title,
$meta_description,
$meta_keywords,
$google_analytics_id,
$meta_pixel_id,
$footer_text,
$id

]);

// ===========================
// Success
// ===========================

$_SESSION['success'] = "Website settings updated successfully.";

header("Location: index.php");
exit;