<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$sql = "
SELECT *
FROM blog_categories
ORDER BY display_order ASC, id DESC
";

$categories = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>Blog Categories</h3>

<a href="create.php" class="btn btn-primary add-btn">

<i class="bi bi-plus-circle"></i>

Add New Category

</a>

</div>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table text-center">

<tr class="thead-row">

<th width="70">ID</th>

<th>Category</th>

<th>Slug</th>

<th>Display Order</th>

<th>Status</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

<?php if(count($categories)>0): ?>

<?php foreach($categories as $row): ?>

<tr>

<td>

<?= $row['id']; ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['title']); ?>

</strong>

</td>

<td>

<?= htmlspecialchars($row['slug']); ?>

</td>

<td>

<?= (int)$row['display_order']; ?>

</td>

<td>

<?php if($row['status']=="Published"): ?>

<span class="badge bg-success">

Published

</span>

<?php else: ?>

<span class="badge bg-secondary">

Draft

</span>

<?php endif; ?>

</td>

<td>

<button
type="button"
class="btn btn-info btn-sm viewCategory"
data-bs-toggle="modal"
data-bs-target="#viewCategoryModal"

data-category='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8"); ?>'>

<i class="bi bi-eye"></i>

</button>

<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this category?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="6" class="text-center">

No blog categories found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>


<div class="modal fade" id="viewCategoryModal" tabindex="-1">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

Category Details

</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<table class="table table-bordered">

<tr>

<th width="220">ID</th>

<td id="catId"></td>

</tr>

<tr>

<th>Category Name</th>

<td id="catTitle"></td>

</tr>

<tr>

<th>Slug</th>

<td id="catSlug"></td>

</tr>

<tr>

<th>Display Order</th>

<td id="catOrder"></td>

</tr>

<tr>

<th>Status</th>

<td id="catStatus"></td>

</tr>

<tr>

<th>Meta Title</th>

<td id="catMetaTitle"></td>

</tr>

<tr>

<th>Meta Description</th>

<td id="catMetaDescription"></td>

</tr>

<tr>

<th>Created At</th>

<td id="catCreated"></td>

</tr>

<tr>

<th>Updated At</th>

<td id="catUpdated"></td>

</tr>

</table>

</div>

</div>

</div>

</div>



<script>

document.querySelectorAll('.viewCategory').forEach(button => {

button.addEventListener('click', function(){

const category = JSON.parse(this.dataset.category);

document.getElementById('catId').innerText = category.id;

document.getElementById('catTitle').innerText = category.title;

document.getElementById('catSlug').innerText = category.slug;

document.getElementById('catOrder').innerText = category.display_order;

document.getElementById('catMetaTitle').innerText =
category.meta_title ?? '-';

document.getElementById('catMetaDescription').innerText =
category.meta_description ?? '-';

document.getElementById('catCreated').innerText =
category.created_at ?? '-';

document.getElementById('catUpdated').innerText =
category.updated_at ?? '-';

document.getElementById('catStatus').innerHTML =
category.status === 'Published'
? '<span class="badge bg-success">Published</span>'
: '<span class="badge bg-secondary">Draft</span>';

});

});

</script>

<?php include '../includes/footer.php'; ?>