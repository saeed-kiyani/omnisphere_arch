<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$sql = "
SELECT

blog.*,

blog_categories.title AS category_name

FROM blog

LEFT JOIN blog_categories

ON blog.category_id = blog_categories.id

ORDER BY blog.id DESC
";

$blogs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Blog Posts</h2>

<a href="create.php" class="btn btn-primary add-btn">

<i class="bi bi-plus-circle"></i>

Add New Blog

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

<th width="80">Image</th>

<th>Title</th>

<th>Category</th>

<th>Author</th>

<th>Status</th>

<th>Featured</th>

<th>Views</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

<?php if(count($blogs)>0): ?>

<?php foreach($blogs as $row): ?>

<tr>

<td>

<?php if(!empty($row['thumbnail'])): ?>

<img
src="../../uploads/blog/<?= htmlspecialchars($row['thumbnail']); ?>"
width="70"
class="img-thumbnail">

<?php else: ?>

—

<?php endif; ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['title']); ?>

</strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['slug']); ?>

</small>

</td>

<td>

<?= htmlspecialchars($row['category_name']); ?>

</td>

<td>

<?= htmlspecialchars($row['author']); ?>

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

<?= $row['featured'] ? 'Yes' : 'No'; ?>

</td>

<td>

<?= (int)$row['views']; ?>

</td>

<td>

<button
type="button"
class="btn btn-info btn-sm viewBlog"

data-bs-toggle="modal"
data-bs-target="#viewBlogModal"

data-blog='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8"); ?>'>

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
onclick="return confirm('Delete this blog?')">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="7" class="text-center">

No blog posts found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="modal fade" id="viewBlogModal" tabindex="-1">

<div class="modal-dialog modal-xl">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

Blog Details

</h5>

<button
type="button"
class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-4 text-center">

<img
id="blogThumbnail"
class="img-fluid rounded shadow mb-3">

</div>

<div class="col-md-8">

<h3 id="blogTitle" class="fw-bold"></h3>

<div class="mb-3">

<span id="blogCategory" class="badge bg-primary"></span>

<span id="blogStatus"></span>

<span id="blogFeatured"></span>

</div>

<table class="table table-bordered">

<tr>
<th width="180">Slug</th>
<td id="blogSlug"></td>
</tr>

<tr>
<th>Short Description</th>
<td id="blogShort"></td>
</tr>

<tr>
<th>Description</th>
<td id="blogDescription"></td>
</tr>

</table>

<div class="accordion mt-4" id="seoAccordion">

<div class="accordion-item">

<h2 class="accordion-header">

<button
class="accordion-button collapsed"
type="button"
data-bs-toggle="collapse"
data-bs-target="#seoCollapse">

SEO Information

</button>

</h2>

<div
id="seoCollapse"
class="accordion-collapse collapse">

<div class="accordion-body">

<p>

<strong>Meta Title</strong>

</p>

<p id="blogMetaTitle"></p>

<hr>

<p>

<strong>Meta Description</strong>

</p>

<p id="blogMetaDescription"></p>

<hr>

<p>

<strong>Created</strong>

</p>

<p id="blogCreated"></p>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

document.querySelectorAll('.viewBlog').forEach(button => {

    button.addEventListener('click', function () {

        const blog = JSON.parse(this.dataset.blog);

        document.getElementById('blogTitle').innerText =
    blog.title || '-';

        document.getElementById('blogSlug').innerText =
    blog.slug || '-';

        document.getElementById('blogCategory').innerText =
    blog.category_name || '-';

        document.getElementById('blogShort').innerText =
    blog.short_description || '-';

        document.getElementById('blogDescription').innerHTML =
    blog.content || '-';

        document.getElementById('blogMetaTitle').innerText =
    blog.meta_title || '-';

document.getElementById('blogMetaDescription').innerText =
    blog.meta_description || '-';

document.getElementById('blogCreated').innerText =
    blog.created_at || '-';

        document.getElementById('blogFeatured').innerHTML =
            blog.featured == 1
            ? '<span class="badge bg-success ms-2">Featured</span>'
            : '<span class="badge bg-secondary ms-2">Normal</span>';

        document.getElementById('blogStatus').innerHTML =
            blog.status == 'Published'
            ? '<span class="badge bg-success ms-2">Published</span>'
            : '<span class="badge bg-warning text-dark ms-2">Draft</span>';

        document.getElementById('blogThumbnail').src =
            blog.thumbnail
            ? '../../uploads/blog/' + blog.thumbnail
            : '../../assets/images/no-image.png';

    });

});

</script>

<?php include '../includes/footer.php'; ?>