<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ============================
// Validate ID
// ============================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int)$_GET['id'];

// ============================
// Fetch Service
// ============================

$stmt = $pdo->prepare("SELECT * FROM services WHERE id=?");
$stmt->execute([$id]);

$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {

    die("Service not found.");

}

$pageTitle = "Edit Service";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Edit Service</h2>

<a href="index.php" class="btn btn-secondary">

Back

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
value="<?= $service['id']; ?>">

<input
type="hidden"
name="old_thumbnail"
value="<?= $service['thumbnail']; ?>">

<!-- Title -->

<div class="mb-3">

<label class="form-label">

Service Title

</label>

<input
type="text"
name="title"
id="title"
class="form-control"
required
value="<?= htmlspecialchars($service['title']); ?>">

</div>

<!-- Slug -->

<div class="mb-3">

<label class="form-label">

Slug

</label>

<input
type="text"
name="slug"
id="slug"
readonly
class="form-control"
value="<?= htmlspecialchars($service['slug']); ?>">

</div>

<!-- Icon -->

<div class="mb-3">

<label class="form-label">

Icon

</label>

<input
type="text"
name="icon"
class="form-control"
value="<?= htmlspecialchars($service['icon']); ?>">

</div>

<!-- Current Image -->

<?php if(!empty($service['thumbnail'])): ?>

<div class="mb-3">

<label class="form-label">

Current Image

</label>

<br>

<img
src="../../uploads/services/<?= htmlspecialchars($service['thumbnail']); ?>"
width="180"
class="img-thumbnail">

</div>

<?php endif; ?>

<!-- Upload New -->

<div class="mb-3">

<label class="form-label">

Change Thumbnail

</label>

<input
type="file"
name="thumbnail"
class="form-control">

</div>

<!-- Short Description -->

<div class="mb-3">

<label class="form-label">

Short Description

</label>

<textarea
name="short_description"
rows="3"
class="form-control"><?= htmlspecialchars($service['short_description']); ?></textarea>

</div>

<!-- Description -->

<div class="mb-3">

<label class="form-label">

Description

</label>

<textarea
name="description"
rows="8"
class="form-control"
required><?= htmlspecialchars($service['description']); ?></textarea>

</div>

<!-- SEO -->

<div class="mb-3">

<label class="form-label">

Meta Title

</label>

<input
type="text"
name="meta_title"
class="form-control"
value="<?= htmlspecialchars($service['meta_title']); ?>">

</div>

<div class="mb-3">

<label class="form-label">

Meta Description

</label>

<textarea
name="meta_description"
rows="3"
class="form-control"><?= htmlspecialchars($service['meta_description']); ?></textarea>

</div>

<!-- Featured -->

<div class="form-check mb-3">

<input
type="checkbox"
class="form-check-input"
name="featured"
value="1"
id="featured"

<?= $service['featured'] ? 'checked' : ''; ?>>

<label
class="form-check-label"
for="featured">

Featured

</label>

</div>

<!-- Status -->

<div class="mb-4">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select">

<option
value="Published"

<?= ($service['status']=="Published") ? 'selected' : ''; ?>>

Published

</option>

<option
value="Draft"

<?= ($service['status']=="Draft") ? 'selected' : ''; ?>>

Draft

</option>

</select>

</div>

<button
class="btn btn-primary">

Update Service

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<script>

document.getElementById('title').addEventListener('keyup',function(){

let slug=this.value.toLowerCase()

.replace(/[^a-z0-9]+/g,'-')

.replace(/^-|-$/g,'');

document.getElementById('slug').value=slug;

});

</script>

<?php include '../includes/footer.php'; ?>