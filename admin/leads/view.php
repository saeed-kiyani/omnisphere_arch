<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    $_SESSION['error'] = "Invalid lead.";

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

// ===========================
// Get Lead
// ===========================

$sql = "
SELECT

contact_leads.*,

services.title AS service_name

FROM contact_leads

LEFT JOIN services

ON contact_leads.service_id = services.id

WHERE contact_leads.id = ?

LIMIT 1
";

$stmt = $pdo->prepare($sql);

$stmt->execute([$id]);

$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {

    $_SESSION['error'] = "Lead not found.";

    header("Location: index.php");
    exit;

}

$pageTitle = "View Lead";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Lead Details</h2>

<div>

<a
href="update-status.php?id=<?= $lead['id']; ?>"
class="btn btn-warning">

<i class="bi bi-pencil-square"></i>

Update Status

</a>

<a
href="index.php"
class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back

</a>

</div>

</div>

<div class="card shadow">

<div class="card-body">

<div class="row">

<!-- Client Name -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Client Name

</label>

<p>

<?= e($lead['full_name']); ?>

</p>

</div>

<!-- Email -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Email

</label>

<p>

<a href="mailto:<?= e($lead['email']); ?>">

<?= e($lead['email']); ?>

</a>

</p>

</div>

<!-- Phone -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Phone

</label>

<p>

<a href="tel:<?= e($lead['phone']); ?>">

<?= e($lead['phone']); ?>

</a>

</p>

</div>

<!-- Service -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Service

</label>

<p>

<?= !empty($lead['service_name']) ? e($lead['service_name']) : '-'; ?>

</p>

</div>

<!-- Subject -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Subject

</label>

<p>

<?= !empty($lead['subject']) ? e($lead['subject']) : '-'; ?>

</p>

</div>

<!-- Budget -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Budget

</label>

<p>

<?= !empty($lead['budget']) ? e($lead['budget']) : '-'; ?>

</p>

</div>

<!-- Location -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Project Location

</label>

<p>

<?= !empty($lead['project_location']) ? e($lead['project_location']) : '-'; ?>

</p>

</div>

<!-- Status -->

<div class="col-md-6 mb-4">

<label class="fw-bold">

Status

</label>

<p>

<?php

$status = strtolower(trim($lead['status']));

if($status=="new"){

    echo '<span class="badge bg-primary">New</span>';

}elseif($status=="contacted"){

    echo '<span class="badge bg-warning text-dark">Contacted</span>';

}elseif($status=="in progress"){

    echo '<span class="badge bg-info text-dark">In Progress</span>';

}elseif($status=="closed"){

    echo '<span class="badge bg-success">Closed</span>';

}else{

    echo '<span class="badge bg-secondary">'.e($lead['status']).'</span>';

}

?>

</p>

</div>

<!-- Message -->

<div class="col-md-12 mb-4">

<label class="fw-bold">

Message

</label>

<div class="border rounded p-3 bg-light">

<?= nl2br(e($lead['message'])); ?>

</div>

</div>

<!-- Notes -->

<div class="col-md-12 mb-4">

<label class="fw-bold">

Internal Notes

</label>

<div class="border rounded p-3 bg-light">

<?= !empty($lead['notes']) ? nl2br(e($lead['notes'])) : '<span class="text-muted">No notes available.</span>'; ?>

</div>

</div>

<!-- Created -->

<div class="col-md-6">

<label class="fw-bold">

Created At

</label>

<p>

<?= date("d M Y h:i A", strtotime($lead['created_at'])); ?>

</p>

</div>

<!-- Updated -->

<div class="col-md-6">

<label class="fw-bold">

Last Updated

</label>

<p>

<?= !empty($lead['updated_at']) ? date("d M Y h:i A", strtotime($lead['updated_at'])) : '-'; ?>

</p>

</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>