<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Handle Form Submission
// ===========================

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id     = (int) $_POST['id'];
    $status = trim($_POST['status']);
    $notes  = trim($_POST['notes']);

    $allowedStatus = [
        'New',
        'Contacted',
        'In Progress',
        'Closed'
    ];

    if (!in_array($status, $allowedStatus)) {

        $_SESSION['error'] = "Invalid status selected.";

        header("Location: update-status.php?id=".$id);
        exit;

    }

    $stmt = $pdo->prepare("
    UPDATE contact_leads
    SET
        status = ?,
        notes = ?,
        updated_at = NOW()
    WHERE id = ?
    ");

    $stmt->execute([
        $status,
        $notes,
        $id
    ]);

    $_SESSION['success'] = "Lead updated successfully.";

    header("Location: index.php");
    exit;

}

// ===========================
// Validate ID
// ===========================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    $_SESSION['error'] = "Invalid lead.";

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

// ===========================
// Fetch Lead
// ===========================

$stmt = $pdo->prepare("
SELECT *
FROM contact_leads
WHERE id = ?
LIMIT 1
");

$stmt->execute([$id]);

$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {

    $_SESSION['error'] = "Lead not found.";

    header("Location: index.php");
    exit;

}

$pageTitle = "Update Lead Status";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Update Lead Status</h2>

<a href="view.php?id=<?= $lead['id']; ?>" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i>
    Back
</a>

</div>

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<div class="card shadow">

<div class="card-body">

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $lead['id']; ?>">

<div class="row">

<!-- Status -->

<div class="col-md-6 mb-4">

<label class="form-label">

Lead Status

</label>

<select
name="status"
class="form-select"
required>

<option value="New"
<?= ($lead['status']=="New") ? "selected" : ""; ?>>

New

</option>

<option value="Contacted"
<?= ($lead['status']=="Contacted") ? "selected" : ""; ?>>

Contacted

</option>

<option value="In Progress"
<?= ($lead['status']=="In Progress") ? "selected" : ""; ?>>

In Progress

</option>

<option value="Closed"
<?= ($lead['status']=="Closed") ? "selected" : ""; ?>>

Closed

</option>

</select>

</div>

<!-- Notes -->

<div class="col-md-12 mb-4">

<label class="form-label">

Internal Notes

</label>

<textarea
name="notes"
rows="8"
class="form-control"
placeholder="Add notes about phone calls, meetings, quotations, follow-up, etc."><?= e($lead['notes']); ?></textarea>

</div>

<div class="col-md-12">

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Update Lead

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>