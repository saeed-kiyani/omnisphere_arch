<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===============================
// Validate ID
// ===============================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

// ===============================
// Fetch Service
// ===============================

$stmt = $pdo->prepare("
SELECT thumbnail
FROM services
WHERE id = ?
");

$stmt->execute([$id]);

$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {

    header("Location: index.php");
    exit;

}

// ===============================
// Delete Thumbnail
// ===============================

if (!empty($service['thumbnail'])) {

    $imagePath = "../../uploads/services/" . $service['thumbnail'];

    if (file_exists($imagePath)) {

        unlink($imagePath);

    }

}

// ===============================
// Delete Database Record
// ===============================

$stmt = $pdo->prepare("
DELETE FROM services
WHERE id = ?
");

$stmt->execute([$id]);

// ===============================
// Redirect
// ===============================

header("Location: index.php?success=deleted");
exit;