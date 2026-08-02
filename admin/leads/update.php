<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';


// =========================================================
// Only POST
// =========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");
    exit;

}


// =========================================================
// Validate ID
// =========================================================

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {

    $_SESSION['error'] = "Invalid lead.";

    header("Location: index.php");
    exit;

}

$id = (int) $_POST['id'];


// =========================================================
// Status
// =========================================================

$allowedStatuses = [

    'New',
    'Contacted',
    'Quotation Sent',
    'Won',
    'Lost'

];

$status = trim($_POST['status'] ?? '');

$notes = trim($_POST['notes'] ?? '');


// =========================================================
// Validate Status
// =========================================================

if (!in_array($status, $allowedStatuses, true)) {

    $_SESSION['error'] = "Invalid lead status.";

    header("Location: view.php?id=" . $id);

    exit;

}


// =========================================================
// Update
// =========================================================

$stmt = $pdo->prepare("
    UPDATE contact_leads

    SET
        status = ?,
        notes = ?

    WHERE id = ?
");


$stmt->execute([

    $status,
    $notes,
    $id

]);


// =========================================================
// Success
// =========================================================

$_SESSION['success'] = "Lead updated successfully.";

header("Location: view.php?id=" . $id);

exit;