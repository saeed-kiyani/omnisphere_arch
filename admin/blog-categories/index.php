<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Blog Categories";

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

<h2>Blog Categories</h2>

<a href="create.php" class="btn btn-primary">

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

<thead class="table-light">

<tr>

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

<a
href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete.php?id=<?= $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this category?')">

Delete

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

<?php include '../includes/footer.php'; ?>