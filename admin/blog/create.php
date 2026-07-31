<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Add New Blog";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Add New Blog</h2>

<a href="index.php" class="btn btn-secondary back-btn">
← Back to Blog
</a>

</div>

<form
action="store.php"
method="POST"
enctype="multipart/form-data">

<?php

$stmt = $pdo->query("
SELECT id, title
FROM blog_categories
ORDER BY display_order ASC, title ASC
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="mb-3">

<label class="form-label">

Category *

</label>

<select
name="category_id"
class="form-control"
required>

<option value="">

Select Category

</option>

<?php foreach($categories as $category): ?>

<option value="<?= $category['id']; ?>">

<?= htmlspecialchars($category['title']); ?>

</option>

<?php endforeach; ?>

</select>

</div>

<!-- Blog Title -->

<div class="mb-3">

<label class="form-label">
Blog Title *
</label>

<input
type="text"
name="title"
id="title"
class="form-control"
required>

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
class="form-control"
readonly>

</div>

<!-- Featured Image -->

<div class="mb-3">

<label class="form-label">
Featured Image
</label>

<input
type="file"
name="thumbnail"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

</div>

<!-- Short Description -->

<div class="mb-3">

<label class="form-label">
Short Description
</label>

<textarea
name="short_description"
class="form-control"
rows="4"></textarea>

</div>

<!-- Content -->

<div class="mb-3">

<label class="form-label">
Blog Content *
</label>

<textarea
name="content"
class="form-control"
rows="12"
required></textarea>

</div>

<!-- Author -->

<div class="mb-3">

<label class="form-label">
Author
</label>

<input
type="text"
name="author"
class="form-control"
value="OmniSphere Architecture">

</div>

<!-- Meta Title -->

<div class="mb-3">

<label class="form-label">
Meta Title
</label>

<input
type="text"
name="meta_title"
class="form-control">

</div>

<!-- Meta Description -->

<div class="mb-3">

<label class="form-label">
Meta Description
</label>

<textarea
name="meta_description"
class="form-control"
rows="4"></textarea>

</div>

<!-- Featured -->

<div class="mb-3 form-check">

<input
type="checkbox"
name="featured"
class="form-check-input"
value="1">

<label class="form-check-label">

Featured Blog

</label>

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

Save Blog

</button>

<a
href="index.php"
class="btn btn-warning">

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