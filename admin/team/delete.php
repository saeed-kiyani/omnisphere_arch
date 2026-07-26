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
// Get Team Member
// ===========================

$stmt = $pdo->prepare("
SELECT profile_image
FROM team
WHERE id = ?
");

$stmt->execute([$id]);

$member = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$member) {

    $_SESSION['error'] = "Team member not found.";

    header("Location: index.php");
    exit;

}

// ===========================
// Delete Profile Image
// ===========================

if (
    !empty($member['profile_image']) &&
    file_exists("../../uploads/team/" . $member['profile_image'])
) {

    unlink("../../uploads/team/" . $member['profile_image']);

}

// ===========================
// Delete Team Member
// ===========================

$stmt = $pdo->prepare("
DELETE FROM team
WHERE id = ?
");

$stmt->execute([$id]);

$member = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$member) {

    $_SESSION['error'] = "Team member not found.";

    header("Location: index.php");
    exit;

}

// ===========================
// Delete Profile Image
// ===========================

if (
    !empty($member['profile_image']) &&
    file_exists("../../uploads/team/" . $member['profile_image'])
) {

    unlink("../../uploads/team/" . $member['profile_image']);

}

// ===========================
// Delete Team Member
// ===========================

$stmt = $pdo->prepare("
DELETE FROM team
WHERE id = ?
");

$stmt->execute([$id]);

// ===========================
// Success Message
// ===========================

$_SESSION['success'] = "Team member deleted successfully.";

header("Location: index.php");
exit;