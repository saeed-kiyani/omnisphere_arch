<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';


// =========================================================
// Validate ID
// =========================================================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];


// =========================================================
// Get Lead
// =========================================================

$stmt = $pdo->prepare("
    SELECT
        l.*,
        s.title AS service_title

    FROM contact_leads l

    LEFT JOIN services s
        ON l.service_id = s.id

    WHERE l.id = ?

    LIMIT 1
");

$stmt->execute([$id]);

$lead = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$lead) {

    $_SESSION['error'] = "Lead not found.";

    header("Location: index.php");
    exit;

}


$pageTitle = "Lead Details";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">


    <!-- Header -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>

                Lead Details

            </h2>

            <p class="text-muted mb-0">

                Lead #<?= (int) $lead['id']; ?>

            </p>

        </div>


        <a
            href="index.php"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>

            Back to Leads

        </a>

    </div>


    <!-- Lead Information -->

    <div class="row g-4">


        <!-- =================================================
             Client Information
        ================================================== -->

        <div class="col-lg-8">

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Client Information

                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-4">


                        <div class="col-md-6">

                            <small class="text-muted">

                                Full Name

                            </small>

                            <h6>

                                <?= e($lead['full_name']); ?>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Email

                            </small>

                            <h6>

                                <a
                                    href="mailto:<?= e($lead['email']); ?>">

                                    <?= e($lead['email']); ?>

                                </a>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Phone

                            </small>

                            <h6>

                                <a
                                    href="tel:<?= e($lead['phone']); ?>">

                                    <?= e($lead['phone']); ?>

                                </a>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Service Required

                            </small>

                            <h6>

                                <?= !empty($lead['service_title'])
                                    ? e($lead['service_title'])
                                    : 'Not specified'; ?>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Subject

                            </small>

                            <h6>

                                <?= !empty($lead['subject'])
                                    ? e($lead['subject'])
                                    : 'Not specified'; ?>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Budget

                            </small>

                            <h6>

                                <?= !empty($lead['budget'])
                                    ? e($lead['budget'])
                                    : 'Not specified'; ?>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                Project Location

                            </small>

                            <h6>

                                <?= !empty($lead['project_location'])
                                    ? e($lead['project_location'])
                                    : 'Not specified'; ?>

                            </h6>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">

                                City / Country

                            </small>

                            <h6>

                                <?php

                                $location = [];

                                if (!empty($lead['city'])) {
                                    $location[] = $lead['city'];
                                }

                                if (!empty($lead['country'])) {
                                    $location[] = $lead['country'];
                                }

                                echo !empty($location)
                                    ? e(implode(', ', $location))
                                    : 'Not specified';

                                ?>

                            </h6>

                        </div>


                    </div>

                </div>

            </div>


            <!-- =================================================
                 Message
            ================================================== -->

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <h5 class="mb-0">

                        Client Message

                    </h5>

                </div>


                <div class="card-body">

                    <p class="mb-0">

                        <?= nl2br(e($lead['message'])); ?>

                    </p>

                </div>

            </div>


            <!-- =================================================
                 Internal Notes
            ================================================== -->

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Internal Notes

                    </h5>

                </div>


                <div class="card-body">

                    <form
                        action="update.php"
                        method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int) $lead['id']; ?>">


                        <div class="mb-3">

                            <label class="form-label">

                                Notes

                            </label>

                            <textarea
                                name="notes"
                                class="form-control"
                                rows="5"
                                placeholder="Add internal notes about this lead..."><?= e($lead['notes']); ?></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-save"></i>

                            Save Notes

                        </button>

                    </form>

                </div>

            </div>

        </div>


        <!-- =================================================
             Lead Management
        ================================================== -->

        <div class="col-lg-4">

            <div class="card shadow-sm">

                <div class="card-header">

                    <h5 class="mb-0">

                        Lead Management

                    </h5>

                </div>


                <div class="card-body">


                    <form
                        action="update.php"
                        method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int) $lead['id']; ?>">


                        <!-- Status -->

                        <div class="mb-4">

                            <label class="form-label">

                                Lead Status

                            </label>

                            <select
                                name="status"
                                class="form-select"
                                required>

                                <option
                                    value="New"
                                    <?= $lead['status'] === 'New' ? 'selected' : ''; ?>>

                                    New

                                </option>

                                <option
                                    value="Contacted"
                                    <?= $lead['status'] === 'Contacted' ? 'selected' : ''; ?>>

                                    Contacted

                                </option>

                                <option
                                    value="Quotation Sent"
                                    <?= $lead['status'] === 'Quotation Sent' ? 'selected' : ''; ?>>

                                    Quotation Sent

                                </option>

                                <option
                                    value="Won"
                                    <?= $lead['status'] === 'Won' ? 'selected' : ''; ?>>

                                    Won

                                </option>

                                <option
                                    value="Lost"
                                    <?= $lead['status'] === 'Lost' ? 'selected' : ''; ?>>

                                    Lost

                                </option>

                            </select>

                        </div>


                        <!-- Notes -->

                        <div class="mb-4">

                            <label class="form-label">

                                Internal Notes

                            </label>

                            <textarea
                                name="notes"
                                class="form-control"
                                rows="6"><?= e($lead['notes']); ?></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="bi bi-check-circle"></i>

                            Update Lead

                        </button>

                    </form>


                    <hr>


                    <!-- Source -->

                    <div class="mb-3">

                        <small class="text-muted">

                            Lead Source

                        </small>

                        <div>

                            <span class="badge bg-secondary">

                                <?= e($lead['source']); ?>

                            </span>

                        </div>

                    </div>


                    <!-- Date -->

                    <div class="mb-3">

                        <small class="text-muted">

                            Submitted

                        </small>

                        <div>

                            <?= date(
                                'd M Y, h:i A',
                                strtotime($lead['created_at'])
                            ); ?>

                        </div>

                    </div>


                    <!-- Updated -->

                    <div>

                        <small class="text-muted">

                            Last Updated

                        </small>

                        <div>

                            <?= date(
                                'd M Y, h:i A',
                                strtotime($lead['updated_at'])
                            ); ?>

                        </div>

                    </div>


                </div>

            </div>

        </div>


    </div>

</div>


<?php include '../includes/footer.php'; ?>