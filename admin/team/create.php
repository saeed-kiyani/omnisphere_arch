<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Add Team Member";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Add Team Member</h2>

<a href="index.php" class="btn btn-secondary back-btn">
← Back to Team Members
</a>

</div>

<form
action="store.php"
method="POST"
enctype="multipart/form-data">

<!-- Full Name -->

<div class="mb-3">

<label class="form-label">

Full Name *

</label>

<input
type="text"
name="full_name"
class="form-control"
required>

</div>

<!-- Designation -->

<div class="mb-3">

<label class="form-label">

Designation *

</label>

<input
type="text"
name="designation"
class="form-control"
required>

</div>

<!-- Profile Image -->

<div class="mb-3">

<label class="form-label">

Profile Image

</label>

<input
type="file"
name="profile_image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

<small class="text-muted">

Maximum size: 2 MB

</small>

</div>

<!-- Bio -->

<div class="mb-3">

<label class="form-label">

Bio

</label>

<textarea
name="bio"
class="form-control"
rows="5"></textarea>

</div>

<!-- Email -->

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control">

</div>

<!-- Phone -->

<div class="mb-3">

<label class="form-label">

Phone

</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<!-- LinkedIn -->

<div class="mb-3">

<label class="form-label">

LinkedIn

</label>

<input
type="url"
name="linkedin"
class="form-control"
placeholder="https://linkedin.com/in/...">

</div>

<!-- Facebook -->

<div class="mb-3">

<label class="form-label">

Facebook

</label>

<input
type="url"
name="facebook"
class="form-control"
placeholder="https://facebook.com/...">

</div>

<!-- Instagram -->

<div class="mb-3">

<label class="form-label">

Instagram

</label>

<input
type="url"
name="instagram"
class="form-control"
placeholder="https://instagram.com/...">

</div>

<!-- Display Order -->

<div class="mb-3">

<label class="form-label">

Display Order

</label>

<input
type="number"
name="display_order"
class="form-control"
value="0">

</div>

<!-- Status -->

<div class="mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-control">

<option value="Published">

Published

</option>

<option value="Draft">

Draft

</option>

</select>

</div>

<button
type="submit"
class="btn btn-primary back-btn">

Save Team Member

</button>

<a
href="index.php"
class="btn btn-warning">

Cancel

</a>

</form>

</div>

</div>

<?php include '../includes/footer.php'; ?>