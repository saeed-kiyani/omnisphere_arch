<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Add Testimonial";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Add New Testimonial</h2>

<a href="index.php" class="btn btn-secondary back-btn">
    <i class="bi bi-arrow-left"></i> ← Back to Testimonials
</a>

</div>

<div class="card shadow">

<div class="card-body">

<form
action="store.php"
method="POST"
enctype="multipart/form-data">

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
class="form-control">

</div>

<!-- Company -->

<div class="col-md-6 mb-3">

<label class="form-label">

Company Name

</label>

<input
type="text"
name="company_name"
class="form-control">

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

<option value="5">★★★★★ (5)</option>
<option value="4">★★★★☆ (4)</option>
<option value="3">★★★☆☆ (3)</option>
<option value="2">★★☆☆☆ (2)</option>
<option value="1">★☆☆☆☆ (1)</option>

</select>

</div>

<!-- Profile Image -->

<div class="col-md-6 mb-3">

<label class="form-label">

Profile Image

</label>

<input
type="file"
name="profile_image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

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
value="0">

</div>

<!-- Featured -->

<select
name="featured"
class="form-select">

<option value="1">

Yes

</option>

<option value="0" selected>

No

</option>

</select>

</div>

<!-- Status -->

<div class="col-md-6 mb-3">

<label class="form-label">

Status *

</label>

<select
name="status"
class="form-select"
required>

<option value="Published">

Published

</option>

<option value="Draft">

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
required></textarea>

</div>

<div class="col-md-12">

<button
type="submit"
class="btn btn-primary back-btn">

<i class="bi bi-save"></i>

Save Testimonial

</button>

<a
href="index.php"
class="btn btn-warning">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>