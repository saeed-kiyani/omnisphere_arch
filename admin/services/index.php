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

                                <?php if($service['featured']) : ?>

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

                                <a
                                href="edit.php?id=<?php echo $service['id']; ?>"
                                class="btn btn-warning btn-sm">

                                    Edit

                                </a>

                                <a
                                href="delete.php?id=<?php echo $service['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this service?')">

                                    Delete

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

<?php include '../includes/footer.php'; ?>