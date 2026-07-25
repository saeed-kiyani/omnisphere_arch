<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Edit Blog";

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int)$_GET['id'];

// Fetch Blog
$stmt = $pdo->prepare("
SELECT *
FROM blog
WHERE id = ?
");

$stmt->execute([$id]);

$blog = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->query("
SELECT id, title
FROM blog_categories
ORDER BY display_order ASC, title ASC
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$blog) {

    die("Blog post not found.");

}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Edit Blog</h2>

<a href="index.php" class="btn btn-secondary">
Back
</a>

</div>

<form
action="update.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $blog['id']; ?>">

<div class="mb-3">

<label class="form-label">

Category *

</label>

<select
name="category_id"
class="form-control"
required>

<?php foreach($categories as $category): ?>

<option
value="<?= $category['id']; ?>"

<?= $blog['category_id']==$category['id']
? 'selected'
: ''; ?>

>

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
value="<?= htmlspecialchars($blog['title']); ?>"
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
value="<?= htmlspecialchars($blog['slug']); ?>"
readonly>

</div>

<!-- Current Image -->

<div class="mb-3">

<label class="form-label">
Current Featured Image
</label>

<br>

<?php if(!empty($blog['thumbnail'])): ?>

<img
src="../../uploads/blog/<?= htmlspecialchars($blog['thumbnail']); ?>"
width="180"
class="img-thumbnail">

<?php else: ?>

<p class="text-muted">
No image uploaded.
</p>

<?php endif; ?>

</div>

<!-- Replace Image -->

<div class="mb-3">

<label class="form-label">
Replace Featured Image
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
rows="4"><?= htmlspecialchars($blog['short_description']); ?></textarea>

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
required><?= htmlspecialchars($blog['content']); ?></textarea>

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
value="<?= htmlspecialchars($blog['author']); ?>">

</div>

<!-- Meta Title -->

<div class="mb-3">

<label class="form-label">
Meta Title
</label>

<input
type="text"
name="meta_title"
class="form-control"
value="<?= htmlspecialchars($blog['meta_title']); ?>">

</div>

<!-- Meta Description -->

<div class="mb-3">

<label class="form-label">
Meta Description
</label>

<textarea
name="meta_description"
class="form-control"
rows="4"><?= htmlspecialchars($blog['meta_description']); ?></textarea>

</div>

<!-- Featured -->

<div class="mb-3 form-check">

<input
type="checkbox"
name="featured"
class="form-check-input"
value="1"
<?= $blog['featured'] ? 'checked' : ''; ?>>

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

<option
value="Published"
<?= $blog['status']=='Published' ? 'selected' : ''; ?>>

Published

</option>

<option
value="Draft"
<?= $blog['status']=='Draft' ? 'selected' : ''; ?>>

Draft

</option>

</select>

</div>

<div class="mt-4">

<button
type="submit"
class="btn btn-primary">

Update Blog

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

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