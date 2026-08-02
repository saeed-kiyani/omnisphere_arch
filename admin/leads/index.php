<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';


// =========================================================
// Search & Filter
// =========================================================

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');


// =========================================================
// Build Query
// =========================================================

$sql = "
    SELECT
        l.*,
        s.title AS service_title

    FROM contact_leads l

    LEFT JOIN services s
        ON l.service_id = s.id

    WHERE 1=1
";

$params = [];


// Search

if ($search !== '') {

    $sql .= "
        AND (
            l.full_name LIKE ?
            OR l.email LIKE ?
            OR l.phone LIKE ?
            OR l.subject LIKE ?
            OR l.project_location LIKE ?
        )
    ";

    $searchTerm = "%{$search}%";

    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}


// Status Filter

if ($status !== '') {

    $sql .= " AND l.status = ? ";

    $params[] = $status;
}


$sql .= "
    ORDER BY l.created_at DESC
";


$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);


// =========================================================
// Status Badge Helper
// =========================================================

function leadStatusBadge($status)
{

    switch ($status) {

        case 'New':
            return 'bg-primary';

        case 'Contacted':
            return 'bg-info text-dark';

        case 'Quotation Sent':
            return 'bg-warning text-dark';

        case 'Won':
            return 'bg-success';

        case 'Lost':
            return 'bg-danger';

        default:
            return 'bg-secondary';

    }

}

?>

<div class="container-fluid mt-4">


    <!-- =====================================================
         Header
    ====================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="mb-1">

                Leads

            </h3>

            <p class="text-muted mb-0">

                Manage website enquiries and potential clients.

            </p>

        </div>

    </div>


    <!-- =====================================================
         Success / Error Messages
    ====================================================== -->

    <?php if (!empty($_SESSION['success'])): ?>

        <div class="alert alert-success">

            <?= e($_SESSION['success']); ?>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>


    <?php if (!empty($_SESSION['error'])): ?>

        <div class="alert alert-danger">

            <?= e($_SESSION['error']); ?>

        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>


    <!-- =====================================================
         Filters
    ====================================================== -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3 align-items-end">


                    <!-- Search -->

                    <div class="col-lg-6">

                        <label class="form-label">

                            Search Leads

                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Name, email, phone, subject..."
                            value="<?= e($search); ?>">

                    </div>


                    <!-- Status -->

                    <div class="col-lg-3">

                        <label class="form-label">

                            Status

                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">

                                All Statuses

                            </option>

                            <option
                                value="New"
                                <?= $status === 'New' ? 'selected' : ''; ?>>

                                New

                            </option>

                            <option
                                value="Contacted"
                                <?= $status === 'Contacted' ? 'selected' : ''; ?>>

                                Contacted

                            </option>

                            <option
                                value="Quotation Sent"
                                <?= $status === 'Quotation Sent' ? 'selected' : ''; ?>>

                                Quotation Sent

                            </option>

                            <option
                                value="Won"
                                <?= $status === 'Won' ? 'selected' : ''; ?>>

                                Won

                            </option>

                            <option
                                value="Lost"
                                <?= $status === 'Lost' ? 'selected' : ''; ?>>

                                Lost

                            </option>

                        </select>

                    </div>


                    <!-- Buttons -->

                    <div class="col-lg-3">

                        <div class="d-flex gap-1">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-search"></i>

                                Search

                            </button>


                            <a
                                href="index.php"
                                class="btn btn-secondary">

                                Reset

                            </a>

                            <a href="export.php" class="btn btn-success">
    <i class="bi bi-file-earmark-spreadsheet"></i>
    Export XLSX
</a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- =====================================================
         Leads Table
    ====================================================== -->

    <div class="card shadow">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Client
                            </th>

                            <th>
                                Service
                            </th>

                            <th>
                                Contact
                            </th>

                            <th>
                                Location
                            </th>

                            <th>
                                Source
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (!empty($leads)): ?>


                        <?php foreach ($leads as $lead): ?>

                            <tr>


                                <!-- ID -->

                                <td>

                                    <?= (int) $lead['id']; ?>

                                </td>


                                <!-- Client -->

                                <td>

                                    <strong>

                                        <?= e($lead['full_name']); ?>

                                    </strong>

                                    <?php if (!empty($lead['subject'])): ?>

                                        <small class="d-block text-muted">

                                            <?= e($lead['subject']); ?>

                                        </small>

                                    <?php endif; ?>

                                </td>


                                <!-- Service -->

                                <td>

                                    <?= !empty($lead['service_title'])
                                        ? e($lead['service_title'])
                                        : '<span class="text-muted">Not specified</span>'; ?>

                                </td>


                                <!-- Contact -->

                                <td>

                                    <a
                                        href="mailto:<?= e($lead['email']); ?>">

                                        <?= e($lead['email']); ?>

                                    </a>

                                    <small class="d-block">

                                        <?= e($lead['phone']); ?>

                                    </small>

                                </td>


                                <!-- Location -->

                                <td>

                                    <?php

                                    $locationParts = [];

                                    if (!empty($lead['city'])) {
                                        $locationParts[] = $lead['city'];
                                    }

                                    if (!empty($lead['country'])) {
                                        $locationParts[] = $lead['country'];
                                    }

                                    ?>

                                    <?= !empty($locationParts)
                                        ? e(implode(', ', $locationParts))
                                        : '<span class="text-muted">N/A</span>'; ?>

                                </td>


                                <!-- Source -->

                                <td>

                                    <span class="badge bg-secondary">

                                        <?= e($lead['source']); ?>

                                    </span>

                                </td>


                                <!-- Status -->

                                <td>

                                    <span class="badge <?= leadStatusBadge($lead['status']); ?>">

                                        <?= e($lead['status']); ?>

                                    </span>

                                </td>


                                <!-- Date -->

                                <td>

                                    <?= date(
                                        'd M Y',
                                        strtotime($lead['created_at'])
                                    ); ?>

                                    <small class="d-block text-muted">

                                        <?= date(
                                            'h:i A',
                                            strtotime($lead['created_at'])
                                        ); ?>

                                    </small>

                                </td>


                                <!-- Actions -->

                                <td>

                                    <div class="d-flex gap-1">


                                        <a
                                            href="view.php?id=<?= (int) $lead['id']; ?>"
                                            class="btn btn-info btn-sm"
                                            title="View">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        <a
                                            href="view.php?id=<?= (int) $lead['id']; ?>"
                                            class="btn btn-warning btn-sm"
                                            title="Edit">

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        <a
                                            href="delete.php?id=<?= (int) $lead['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this lead?');">

                                            <i class="bi bi-trash"></i>

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>


                    <?php else: ?>

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5">

                                <i
                                    class="bi bi-inbox fs-1 text-muted">
                                </i>

                                <h5 class="mt-3">

                                    No Leads Found

                                </h5>

                                <p class="text-muted mb-0">

                                    There are currently no leads matching your search.

                                </p>

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