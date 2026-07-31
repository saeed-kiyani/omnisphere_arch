<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ==============================
// Fetch Portfolio Projects
// ==============================

$sql = "
SELECT
    portfolio.*,
    services.title AS service_title

FROM portfolio

LEFT JOIN services
ON portfolio.service_id = services.id

ORDER BY portfolio.id DESC
";

$stmt = $pdo->query($sql);

$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/sidebar.php'; ?>
<?php include '../includes/topbar.php'; ?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Portfolio Projects</h2>

        <a href="create.php" class="btn btn-primary add-btn">
            + Add New Project
        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table text-center">

                        <tr class="thead-row">

                            <th width="80">Image</th>

                            <th>Project</th>

                            <th>Service</th>

                            <th>Location</th>

                            <th>Year</th>

                            <th>Status</th>

                            <th>Featured</th>

                            <th>Published</th>

                            <th width="170">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(count($projects)>0): ?>

                        <?php foreach($projects as $project): ?>

                        <tr>

                            <td>

                                <?php if(!empty($project['thumbnail'])): ?>

                                    <img
                                    src="../../uploads/portfolio/<?=
                                    htmlspecialchars($project['thumbnail']); ?>"
                                    width="70"
                                    class="img-thumbnail">

                                <?php else: ?>

                                    No Image

                                <?php endif; ?>

                            </td>

                            <td>

                                <strong>

                                <?= htmlspecialchars($project['title']); ?>

                                </strong>

                            </td>

                            <td>

                                <?= htmlspecialchars($project['service_title']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($project['location']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($project['project_year']); ?>

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    <?= htmlspecialchars($project['project_status']); ?>

                                </span>

                            </td>

                            <td>

                                <?php if($project['featured']): ?>

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

                                <?php if($project['status']=="Published"): ?>

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

<button
type="button"
class="btn btn-info btn-sm viewPortfolio"

data-bs-toggle="modal"

data-bs-target="#viewPortfolioModal"

data-title="<?= e($project['title']); ?>"

data-service="<?= e($project['service_title'] ?? ''); ?>"

data-client="<?= e($project['client_name']); ?>"

data-location="<?= e($project['location']); ?>"

data-year="<?= e($project['project_year']); ?>"

data-area="<?= e($project['project_area']); ?>"

data-status="<?= e($project['status']); ?>"

data-featured="<?= $project['featured']; ?>"

data-thumbnail="<?= e($project['thumbnail']); ?>"

data-short="<?= e($project['short_description']); ?>"

data-description="<?= htmlspecialchars($project['description']); ?>">

<i class="bi bi-eye"></i>

</button>

<a
href="edit.php?id=<?= $project['id']; ?>"
class="btn btn-warning btn-sm">

<i class="bi bi-pencil"></i>

</a>

<a
href="delete.php?id=<?= $project['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this project?')">

<i class="bi bi-trash"></i>

</a>

</td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="9" class="text-center">

                                No Portfolio Projects Found

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="viewPortfolioModal" tabindex="-1">

<div class="modal-dialog modal-xl">

<div class="modal-content">

<div class="modal-header">

<h5 class="modal-title">

Portfolio Project Details

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
id="modalThumbnail"
class="img-fluid rounded shadow mb-3">

</div>

<div class="col-md-8">

<table class="table table-bordered">

<tr>

<th width="180">Title</th>

<td id="modalTitle"></td>

</tr>

<tr>

<th>Service</th>

<td id="modalService"></td>

</tr>

<tr>

<th>Client</th>

<td id="modalClient"></td>

</tr>

<tr>

<th>Location</th>

<td id="modalLocation"></td>

</tr>

<tr>

<th>Project Year</th>

<td id="modalYear"></td>

</tr>

<tr>

<th>Project Area</th>

<td id="modalArea"></td>

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

</table>

</div>

</div>

</div>

</div>

</div>

</div>


<script>

document.querySelectorAll('.viewPortfolio').forEach(button=>{

button.addEventListener('click',function(){

document.getElementById('modalTitle').innerText=this.dataset.title;

document.getElementById('modalService').innerText=this.dataset.service;

document.getElementById('modalClient').innerText=this.dataset.client;

document.getElementById('modalLocation').innerText=this.dataset.location;

document.getElementById('modalYear').innerText=this.dataset.year;

document.getElementById('modalArea').innerText=this.dataset.area;

document.getElementById('modalShort').innerText=this.dataset.short;

document.getElementById('modalDescription').innerHTML=this.dataset.description;

document.getElementById('modalFeatured').innerHTML=

this.dataset.featured==1

?'<span class="badge bg-success">Yes</span>'

:'<span class="badge bg-secondary">No</span>';

document.getElementById('modalStatus').innerHTML=

this.dataset.status=='Published'

?'<span class="badge bg-success">Published</span>'

:'<span class="badge bg-warning text-dark">Draft</span>';

let image=this.dataset.thumbnail;

document.getElementById('modalThumbnail').src=

image

? '../../uploads/portfolio/'+image

: '../../assets/images/no-image.png';

});

});

</script>

<?php include '../includes/footer.php'; ?>