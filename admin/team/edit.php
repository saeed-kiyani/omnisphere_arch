<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Edit Team Member";

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int)$_GET['id'];

// ===========================
// Fetch Team Member
// ===========================

$stmt = $pdo->prepare("
SELECT *
FROM team
WHERE id = ?
");

$stmt->execute([$id]);

$member = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$member) {

    die("Team member not found.");

}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<h2>Edit Team Member</h2>

<hr>

<form
action="update.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $member['id']; ?>">

<div class="mb-3">

<label class="form-label">

Full Name *

</label>

<input
type="text"
name="full_name"
class="form-control"
required
value="<?= htmlspecialchars($member['full_name']); ?>">

</div>

<div class="mb-3">

<label class="form-label">

Designation *

</label>

<input
type="text"
name="designation"
class="form-control"
required
value="<?= htmlspecialchars($member['designation']); ?>">

</div>

<div class="mb-3">

<label class="form-label">

Current Profile Image

</label>

<br>

<?php if(!empty($member['profile_image'])): ?>

<img
src="../../uploads/team/<?= htmlspecialchars($member['profile_image']); ?>"
width="150"
class="img-thumbnail mb-2">

<?php else: ?>

<p>No Image</p>

<?php endif; ?>

</div>

<div class="mb-3">

<label class="form-label">

Replace Profile Image

</label>

<input
type="file"
name="profile_image"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">

Bio

</label>

<textarea
name="bio"
rows="5"
class="form-control"><?= htmlspecialchars($member['bio']); ?></textarea>

</div>

<div class="row">

<div class="col-md-6">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($member['email']); ?>">

</div>

<div class="col-md-6">

<label class="form-label">

Phone

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= htmlspecialchars($member['phone']); ?>">

</div>

</div>

<br>

<div class="mb-3">

<label class="form-label">

LinkedIn

</label>

<input
type="url"
name="linkedin"
class="form-control"
value="<?= htmlspecialchars($member['linkedin']); ?>">

</div>

<div class="mb-3">

<label class="form-label">

Facebook

</label>

<input
type="url"
name="facebook"
class="form-control"
value="<?= htmlspecialchars($member['facebook']); ?>">

</div>

<div class="mb-3">

<label class="form-label">

Instagram

</label>

<input
type="url"
name="instagram"
class="form-control"
value="<?= htmlspecialchars($member['instagram']); ?>">

</div>

<div class="row">

<div class="col-md-6">

<label class="form-label">

Display Order

</label>

<input
type="number"
name="display_order"
class="form-control"
value="<?= $member['display_order']; ?>">

</div>

<div class="col-md-6">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-control">

<option
value="Published"
<?= $member['status']=='Published' ? 'selected' : ''; ?>>

Published

</option>

<option
value="Draft"
<?= $member['status']=='Draft' ? 'selected' : ''; ?>>

Draft

</option>

</select>

</div>

</div>

<br>

<button
type="submit"
class="btn btn-primary">

Update Team Member

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

<?php include '../includes/footer.php'; ?>