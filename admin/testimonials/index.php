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

<a href="create.php" class="btn btn-primary add-btn">
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

<thead class="table text-center">

<tr class="thead-row">

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

<?php if ((int)$row['featured'] === 1): ?>

    <span class="badge bg-success">
        Yes
    </span>

<?php else: ?>

    <span class="badge bg-secondary">
        No
    </span>

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

<button
type="button"
class="btn btn-info btn-sm viewTestimonial"
data-bs-toggle="modal"
data-bs-target="#viewTestimonialModal"
data-testimonial='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8"); ?>'>

<i class="bi bi-eye"></i>

</button>

<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this testimonial?')">

<i class="bi bi-trash"></i>

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


<!-- View Testimonial Modal -->

<div class="modal fade" id="viewTestimonialModal" tabindex="-1">

<div class="modal-dialog modal-xl">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">
Testimonial Details
</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-4 text-center">

<img
id="testimonialPhoto"
class="img-fluid rounded shadow mb-3"
style="
width:220px;
height:220px;
object-fit:cover;
">

</div>

<div class="col-md-8">

<table class="table table-bordered">

<tr>
<th width="180">Client Name</th>
<td id="testimonialClient"></td>
</tr>

<tr>
<th>Designation</th>
<td id="testimonialDesignation"></td>
</tr>

<tr>
<th>Company</th>
<td id="testimonialCompany"></td>
</tr>

<tr>
<th>Rating</th>
<td id="testimonialRating"></td>
</tr>

<tr>
<th>Review</th>
<td>
<div
id="testimonialReview"
style="
max-height:220px;
overflow-y:auto;
"></div>
</td>
</tr>

<tr>
<th>Featured</th>
<td id="testimonialFeatured"></td>
</tr>

<tr>
<th>Display Order</th>
<td id="testimonialOrder"></td>
</tr>

<tr>
<th>Status</th>
<td id="testimonialStatus"></td>
</tr>

</table>

</div>

</div>

</div>

</div>

</div>

</div>


<script>

document.querySelectorAll('.viewTestimonial').forEach(button=>{

button.addEventListener('click',function(){

const t = JSON.parse(this.dataset.testimonial);

document.getElementById('testimonialPhoto').src =
t.profile_image
? '../../uploads/testimonials/' + t.profile_image
: '../../assets/images/no-image.png';

document.getElementById('testimonialClient').innerText =
t.client_name || '-';

document.getElementById('testimonialDesignation').innerText =
t.designation || '-';

document.getElementById('testimonialCompany').innerText =
t.company_name || '-';

document.getElementById('testimonialReview').innerHTML =
t.review || '-';

let stars='';

for(let i=1;i<=5;i++){

stars += (i<=parseInt(t.rating))

? '<i class="bi bi-star-fill text-warning"></i> '

: '<i class="bi bi-star text-warning"></i> ';

}

document.getElementById('testimonialRating').innerHTML = stars;

document.getElementById('testimonialFeatured').innerHTML =
t.featured=='Yes'
? '<span class="badge bg-success">Yes</span>'
: '<span class="badge bg-secondary">No</span>';

document.getElementById('testimonialOrder').innerText =
t.display_order;

document.getElementById('testimonialStatus').innerHTML =
t.status=='Published'
? '<span class="badge bg-success">Published</span>'
: '<span class="badge bg-warning text-dark">Draft</span>';

});

});

</script>

<?php require_once '../includes/footer.php'; ?>