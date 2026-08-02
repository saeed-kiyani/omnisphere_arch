<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';


// =========================================================
// Validate ID
// =========================================================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    $_SESSION['error'] = "Invalid lead.";

    header("Location: index.php");

    exit;

}

$id = (int) $_GET['id'];


// =========================================================
// Check Lead
// =========================================================

$stmt = $pdo->prepare("
    SELECT id
    FROM contact_leads
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$lead = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$lead) {

    $_SESSION['error'] = "Lead not found.";

    header("Location: index.php");

    exit;

}


// =========================================================
// Delete
// =========================================================

$stmt = $pdo->prepare("
    DELETE FROM contact_leads
    WHERE id = ?
");

$stmt->execute([$id]);


// =========================================================
// Success
// =========================================================

$_SESSION['success'] = "Lead deleted successfully.";

header("Location: index.php");

exit;