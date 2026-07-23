<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ==============================
// Fetch Portfolio Projects
// ==============================

$sql = "
SELECT
    portfolio.*,
    services.title AS service_name

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

        <a href="create.php" class="btn btn-primary">
            + Add New Project
        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

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

                                <?= htmlspecialchars($project['service_name']); ?>

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

                                <a
                                href="edit.php?id=<?= $project['id']; ?>"
                                class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <a
                                href="delete.php?id=<?= $project['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this project?')">

                                    Delete

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

<?php include '../includes/footer.php'; ?>