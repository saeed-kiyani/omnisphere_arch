<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

// Fetch Project
$stmt = $pdo->prepare("
SELECT *
FROM portfolio
WHERE id = ?
");

$stmt->execute([$id]);

$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {

    die("Project not found.");

}

// Fetch Services
$stmt = $pdo->query("
SELECT id, title
FROM services
ORDER BY title ASC
");

$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

  <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Edit Portfolio Project</h2>

        <a href="index.php" class="btn btn-secondary">
            ← Back
        </a>

    </div>

<hr>

<form
action="update.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $project['id']; ?>">

<div class="mb-3">

<label>Select Service *</label>

<select
name="service_id"
class="form-control"
required>

<?php foreach($services as $service): ?>

<option
value="<?= $service['id']; ?>"

<?= $project['service_id']==$service['id']
? 'selected'
: ''; ?>

>

<?= htmlspecialchars($service['title']); ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Project Title *</label>

<input
type="text"
name="title"
id="title"
class="form-control"
value="<?= htmlspecialchars($project['title']); ?>"
required>

</div>

<div class="mb-3">

<label>Slug</label>

<input
type="text"
name="slug"
id="slug"
class="form-control"
value="<?= htmlspecialchars($project['slug']); ?>"
readonly>

</div>

<div class="mb-3">

<label>Client Name</label>

<input
type="text"
name="client_name"
class="form-control"
value="<?= htmlspecialchars($project['client_name']); ?>">

</div>

<div class="mb-3">

<label>Location</label>

<input
type="text"
name="location"
class="form-control"
value="<?= htmlspecialchars($project['location']); ?>">

</div>

<div class="mb-3">

<label>Project Year</label>

<input
type="number"
name="project_year"
class="form-control"
value="<?= $project['project_year']; ?>">

</div>

<div class="mb-3">

<label>Project Area</label>

<input
type="text"
name="project_area"
class="form-control"
value="<?= htmlspecialchars($project['project_area']); ?>">

</div>

<select name="project_status" class="form-control">

<option value="Concept"
<?= $project['project_status']=="Concept" ? "selected" : ""; ?>>

Concept

</option>

<option value="In Progress"
<?= $project['project_status']=="In Progress" ? "selected" : ""; ?>>

In Progress

</option>

<option value="Completed"
<?= $project['project_status']=="Completed" ? "selected" : ""; ?>>

Completed

</option>

</select>

<div class="mb-3">

<label>Current Thumbnail</label>

<br>

<?php if(!empty($project['thumbnail'])): ?>

<img
src="../../uploads/portfolio/<?= $project['thumbnail']; ?>"
width="180">

<?php else: ?>

No Image

<?php endif; ?>

</div>

<div class="mb-3">

<label>Replace Thumbnail</label>

<input
type="file"
name="thumbnail"
class="form-control">

</div>

<div class="mb-3">

<label>Short Description</label>

<textarea
name="short_description"
class="form-control"
rows="4"><?= htmlspecialchars($project['short_description']); ?></textarea>

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"
rows="8"><?= htmlspecialchars($project['description']); ?></textarea>

</div>

<div class="mb-3">

<label>Meta Title</label>

<input
type="text"
name="meta_title"
class="form-control"
value="<?= htmlspecialchars($project['meta_title']); ?>">

</div>

<div class="mb-3">

<label>Meta Description</label>

<textarea
name="meta_description"
class="form-control"
rows="4"><?= htmlspecialchars($project['meta_description']); ?></textarea>

</div>

<div class="mb-3 form-check">

<input
type="checkbox"
class="form-check-input"
name="featured"
value="1"
<?= $project['featured'] ? 'checked' : ''; ?>>

<label class="form-check-label">

Featured Project

</label>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option
value="Published"

<?= $project['status']=='Published'
? 'selected'
: ''; ?>

>

Published

</option>

<option
value="Draft"

<?= $project['status']=='Draft'
? 'selected'
: ''; ?>

>

Draft

</option>

</select>

</div>

<div class="mt-4">

<button
type="submit"
class="btn btn-primary">

Update Project

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

<script>

function slugify(text){

return text
.toLowerCase()
.trim()
.replace(/[^\w\s-]/g,'')
.replace(/\s+/g,'-')
.replace(/-+/g,'-');

}

document.getElementById("title").addEventListener("keyup",function(){

document.getElementById("slug").value=slugify(this.value);

});

</script>

<?php include '../includes/footer.php'; ?>