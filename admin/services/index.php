<?php
require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Fetch all services
$stmt = $pdo->query("
SELECT *
FROM services
ORDER BY id DESC
");

$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>
<?php include '../includes/topbar.php'; ?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Services</h2>

        <a href="create.php" class="btn btn-primary">
            + Add New Service
        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th width="80">Image</th>

                            <th>Title</th>

                            <th>Slug</th>

                            <th width="100">Featured</th>

                            <th width="120">Status</th>

                            <th width="180">Created</th>

                            <th width="160">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(count($services)>0): ?>

                        <?php foreach($services as $service): ?>

                        <tr>

                            <td>

                                <?php if(!empty($service['thumbnail'])): ?>

                                    <img
                                    src="../../uploads/services/<?php echo htmlspecialchars($service['thumbnail']); ?>"
                                    width="60"
                                    class="img-thumbnail">

                                <?php else: ?>

                                    No Image

                                <?php endif; ?>

                            </td>

                            <td>

                                <?php echo htmlspecialchars($service['title']); ?>

                            </td>

                            <td>

                                <?php echo htmlspecialchars($service['slug']); ?>

                            </td>

                          <td>

<?php if ((int)$service['featured'] === 1): ?>

    <span class="badge bg-success">
        Yes
    </span>

<?php else: ?>

    <span class="badge bg-secondary">
        No
    </span>

<?php endif; ?>

</td>

                            <td>

                                <?php if($service['status']=="Published"): ?>

                                    <span class="badge bg-primary">

                                        Published

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-warning text-dark">

                                        Draft

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?php

                                echo date(
                                    "d M Y",
                                    strtotime($service['created_at'])
                                );

                                ?>

                            </td>

                         <td>

<button
type="button"
class="btn btn-info btn-sm viewService"
data-bs-toggle="modal"
data-bs-target="#viewServiceModal"

data-title="<?= e($service['title']); ?>"
data-slug="<?= e($service['slug']); ?>"
data-image="<?= e($service['thumbnail']); ?>"
data-featured="<?= $service['featured']; ?>"
data-status="<?= e($service['status']); ?>"
data-short="<?= e($service['short_description']); ?>"
data-description="<?= htmlspecialchars($service['description']); ?>"
data-meta-title="<?= e($service['meta_title']); ?>"
data-meta-description="<?= e($service['meta_description']); ?>"
data-created="<?= date('d M Y', strtotime($service['created_at'])); ?>"
>

<i class="bi bi-eye"></i>

</button>

<a
href="edit.php?id=<?= $service['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete.php?id=<?= $service['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this service?')">

<i class="bi bi-trash"></i>

</a>

</td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="7" class="text-center">

                                No Services Found

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="viewServiceModal" tabindex="-1">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

Service Details

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
id="modalImage"
class="img-fluid rounded shadow">

</div>

<div class="col-md-8">

<table class="table table-bordered">

<tr>
<th width="180">Title</th>
<td id="modalTitle"></td>
</tr>

<tr>
<th>Slug</th>
<td id="modalSlug"></td>
</tr>

<tr>
<th>Featured</th>
<td id="modalFeatured"></td>
</tr>

<tr>
<th>Status</th>
<td id="modalStatus"></td>
</tr>

<tr>
<th>Short Description</th>
<td id="modalShort"></td>
</tr>

<tr>
<th>Description</th>
<td id="modalDescription"></td>
</tr>

<tr>
<th>Meta Title</th>
<td id="modalMetaTitle"></td>
</tr>

<tr>
<th>Meta Description</th>
<td id="modalMetaDescription"></td>
</tr>

<tr>
<th>Created</th>
<td id="modalCreated"></td>
</tr>

</table>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

document.querySelectorAll('.viewService').forEach(button => {

button.addEventListener('click', function(){

document.getElementById('modalTitle').innerText =
this.dataset.title;

document.getElementById('modalSlug').innerText =
this.dataset.slug;

document.getElementById('modalFeatured').innerHTML =
this.dataset.featured == 1
? '<span class="badge bg-success">Yes</span>'
: '<span class="badge bg-secondary">No</span>';

document.getElementById('modalStatus').innerHTML =
this.dataset.status == 'Published'
? '<span class="badge bg-success">Published</span>'
: '<span class="badge bg-warning text-dark">Draft</span>';

document.getElementById('modalShort').innerText =
this.dataset.short;

document.getElementById('modalDescription').innerHTML =
this.dataset.description;

document.getElementById('modalMetaTitle').innerText =
this.dataset.metaTitle;

document.getElementById('modalMetaDescription').innerText =
this.dataset.metaDescription;

document.getElementById('modalCreated').innerText =
this.dataset.created;

let image=this.dataset.image;

document.getElementById('modalImage').src=
image
? '../../uploads/services/'+image
: '../../assets/images/no-image.png';

});

});

</script>

<?php include '../includes/footer.php'; ?>