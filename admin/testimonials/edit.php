<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

// ===========================
// Get Testimonial
// ===========================

$stmt = $pdo->prepare("
SELECT *
FROM testimonials
WHERE id = ?
LIMIT 1
");

$stmt->execute([$id]);

$testimonial = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$testimonial) {

    $_SESSION['error'] = "Testimonial not found.";

    header("Location: index.php");
    exit;

}

$pageTitle = "Edit Testimonial";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Edit Testimonial</h2>

<a href="index.php" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Back
</a>

</div>

<div class="card shadow">

<div class="card-body">

<form
action="update.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $testimonial['id']; ?>">

<div class="row">

<!-- Client Name -->

<div class="col-md-6 mb-3">

<label class="form-label">

Client Name *

</label>

<input
type="text"
name="client_name"
class="form-control"
value="<?= e($testimonial['client_name']); ?>"
required>

</div>

<!-- Designation -->

<div class="col-md-6 mb-3">

<label class="form-label">

Designation

</label>

<input
type="text"
name="designation"
class="form-control"
value="<?= e($testimonial['designation']); ?>">

</div>

<!-- Company -->

<div class="col-md-6 mb-3">

<label class="form-label">

Company Name

</label>

<input
type="text"
name="company_name"
class="form-control"
value="<?= e($testimonial['company_name']); ?>">

</div>

<!-- Rating -->

<div class="col-md-6 mb-3">

<label class="form-label">

Rating *

</label>

<select
name="rating"
class="form-select"
required>

<?php for($i=5;$i>=1;$i--): ?>

<option
value="<?= $i; ?>"
<?= ($testimonial['rating']==$i) ? 'selected' : ''; ?>>

<?= str_repeat('★',$i); ?> (<?= $i; ?>)

</option>

<?php endfor; ?>

</select>

</div>

<!-- Current Image -->

<div class="col-md-6 mb-3">

<label class="form-label">

Current Image

</label>

<br>

<?php if(!empty($testimonial['profile_image'])): ?>

<img
src="../../uploads/testimonials/<?= e($testimonial['profile_image']); ?>"
style="width:120px;height:120px;object-fit:cover;border-radius:10px;"
class="img-thumbnail">

<?php else: ?>

<p class="text-muted">

No Image

</p>

<?php endif; ?>

</div>

<!-- Replace Image -->

<div class="col-md-6 mb-3">

<label class="form-label">

Replace Image

</label>

<input
type="file"
name="profile_image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

</div>

<!-- Featured -->

<div class="col-md-6 mb-3">

<label class="form-label">

Featured

</label>

<select
name="featured"
class="form-select">

<option
value="Yes"
<?= ($testimonial['featured']=="Yes") ? 'selected' : ''; ?>>

Yes

</option>

<option
value="No"
<?= ($testimonial['featured']=="No") ? 'selected' : ''; ?>>

No

</option>

</select>

</div>

<!-- Display Order -->

<div class="col-md-6 mb-3">

<label class="form-label">

Display Order

</label>

<input
type="number"
name="display_order"
class="form-control"
value="<?= $testimonial['display_order']; ?>">

</div>

<!-- Status -->

<div class="col-md-6 mb-3">

<label class="form-label">

Status *

</label>

<select
name="status"
class="form-select">

<option
value="Published"
<?= ($testimonial['status']=="Published") ? 'selected' : ''; ?>>

Published

</option>

<option
value="Draft"
<?= ($testimonial['status']=="Draft") ? 'selected' : ''; ?>>

Draft

</option>

</select>

</div>

<!-- Review -->

<div class="col-md-12 mb-4">

<label class="form-label">

Review *

</label>

<textarea
name="review"
rows="6"
class="form-control"
required><?= e($testimonial['review']); ?></textarea>

</div>

<div class="col-md-12">

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Update Testimonial

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>