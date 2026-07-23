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
WHERE status='Published'
ORDER BY title ASC
");

$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';

?>

<div class="container-fluid mt-4">

<h2>Edit Portfolio Project</h2>

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

<textarea
name="short_description"
class="form-control"
rows="4"><?= htmlspecialchars($project['short_description']); ?></textarea>

<textarea
name="description"
class="form-control"
rows="8"><?= htmlspecialchars($project['description']); ?></textarea>

<input
type="text"
name="meta_title"
class="form-control"
value="<?= htmlspecialchars($project['meta_title']); ?>">

<textarea
name="meta_description"
class="form-control"
rows="4"><?= htmlspecialchars($project['meta_description']); ?></textarea>

<input
type="checkbox"
name="featured"
value="1"

<?= $project['featured'] ? 'checked' : ''; ?>

>
Featured Project

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

<?php include '../includes/footer.php'; ?>