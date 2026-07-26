<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ==========================
// Get Testimonials
// ==========================

$sql = "
SELECT *
FROM testimonials
ORDER BY display_order ASC, id DESC
";

$stmt = $pdo->query($sql);
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>
<?php include '../includes/topbar.php'; ?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h1 class="mb-0">Testimonials</h1>

<a href="create.php" class="btn btn-primary">
<i class="bi bi-plus-lg"></i>
Add New Testimonial
</a>

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

<table class="table table-bordered table-hover align-middle mb-0">

<thead class="table-dark">

<tr>

<th width="80">Photo</th>

<th>Client</th>

<th>Company</th>

<th width="90">Rating</th>

<th width="90">Featured</th>

<th width="100">Status</th>

<th width="170">Actions</th>

</tr>

</thead>

<tbody>

<?php if(count($testimonials)>0): ?>

<?php foreach($testimonials as $row): ?>

<tr>

<td>

<?php if(!empty($row['profile_image'])): ?>

<img
src="../../uploads/testimonials/<?= e($row['profile_image']); ?>"
style="width:60px;height:60px;object-fit:cover;border-radius:50%;">

<?php else: ?>

<img
src="../../assets/images/no-image.png"
style="width:60px;height:60px;border-radius:50%;">

<?php endif; ?>

</td>

<td>

<strong><?= e($row['client_name']); ?></strong>

<br>

<small class="text-muted">

<?= e($row['designation']); ?>

</small>

</td>

<td>

<?= e($row['company_name']); ?>

</td>

<td>

<?php

for($i=1;$i<=5;$i++){

    if($i <= $row['rating']){

        echo '<i class="bi bi-star-fill text-warning"></i>';

    }else{

        echo '<i class="bi bi-star text-warning"></i>';

    }

}

?>

</td>

<td>

<?php if($row['featured']=="Yes"): ?>

<span class="badge bg-success">Yes</span>

<?php else: ?>

<span class="badge bg-secondary">No</span>

<?php endif; ?>

</td>

<td>

<?php if($row['status']=="Published"): ?>

<span class="badge bg-success">

Published

</span>

<?php else: ?>

<span class="badge bg-warning text-dark">

Draft

</span>

<?php endif; ?>

</td>

<td>

<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this testimonial?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="7" class="text-center">

No testimonials found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<?php require_once '../includes/footer.php'; ?>