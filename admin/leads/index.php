<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Fetch All Leads
// ===========================

$sql = "
SELECT

contact_leads.*,

services.title AS service_name

FROM contact_leads

LEFT JOIN services

ON contact_leads.service_id = services.id

ORDER BY contact_leads.created_at DESC
";

$stmt = $pdo->query($sql);

$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>
<?php include '../includes/topbar.php'; ?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Contact Leads</h2>

<div>

<a
href="export.php"
class="btn btn-success">

<i class="bi bi-download"></i>

Export CSV

</a>

</div>

</div>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<div class="card shadow">

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th width="70">ID</th>

<th>Client</th>

<th>Email</th>

<th>Phone</th>

<th>Service</th>

<th>Budget</th>

<th>Location</th>

<th width="120">Status</th>

<th width="140">Received</th>

<th width="200">Actions</th>

</tr>

</thead>

<tbody>

<?php if(count($leads)>0): ?>

<?php foreach($leads as $lead): ?>

<tr>

<td>

<?= $lead['id']; ?>

</td>

<td>

<strong>

<?= e($lead['full_name']); ?>

</strong>

</td>

<td>

<?= e($lead['email']); ?>

</td>

<td>

<?= e($lead['phone']); ?>

</td>

<td>

<?= !empty($lead['service_name']) ? e($lead['service_name']) : '-'; ?>

</td>

<td>

<?= !empty($lead['budget']) ? e($lead['budget']) : '-'; ?>

</td>

<td>

<?= !empty($lead['project_location']) ? e($lead['project_location']) : '-'; ?>

</td>

<td>

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

</td>

<td>

<?= date("d M Y", strtotime($lead['created_at'])); ?>

</td>

<td>

<a
href="view.php?id=<?= $lead['id']; ?>"
class="btn btn-info btn-sm">

View

</a>

<a
href="update-status.php?id=<?= $lead['id']; ?>"
class="btn btn-warning btn-sm">

Status

</a>

<a
href="delete.php?id=<?= $lead['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this lead?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="10" class="text-center">

No Leads Found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>