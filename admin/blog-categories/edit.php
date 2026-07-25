<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Edit Blog Category";

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int)$_GET['id'];

// Fetch Category
$stmt = $pdo->prepare("
SELECT *
FROM blog_categories
WHERE id = ?
");

$stmt->execute([$id]);

$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {

    die("Category not found.");

}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Edit Blog Category</h2>

<a href="index.php" class="btn btn-secondary">
Back
</a>

</div>

<form action="update.php" method="POST">

<input
type="hidden"
name="id"
value="<?= $category['id']; ?>">

<div class="mb-3">

<label class="form-label">

Category Title *

</label>

<input
type="text"
name="title"
id="title"
class="form-control"
value="<?= htmlspecialchars($category['title']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Slug

</label>

<input
type="text"
name="slug"
id="slug"
class="form-control"
value="<?= htmlspecialchars($category['slug']); ?>"
readonly>

</div>

<div class="mb-3">

<label class="form-label">

Meta Title

</label>

<input
type="text"
name="meta_title"
class="form-control"
value="<?= htmlspecialchars($category['meta_title']); ?>">

</div>

<div class="mb-3">

<label class="form-label">

Meta Description

</label>

<textarea
name="meta_description"
class="form-control"
rows="4"><?= htmlspecialchars($category['meta_description']); ?></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Display Order

</label>

<input
type="number"
name="display_order"
class="form-control"
value="<?= $category['display_order']; ?>">

</div>

<div class="mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-control">

<option
value="Published"
<?= $category['status']=='Published' ? 'selected' : ''; ?>>

Published

</option>

<option
value="Draft"
<?= $category['status']=='Draft' ? 'selected' : ''; ?>>

Draft

</option>

</select>

</div>

<button
type="submit"
class="btn btn-primary">

Update Category

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

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