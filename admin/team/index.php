<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Team Members";

$sql = "
SELECT *
FROM team
ORDER BY display_order ASC, id DESC
";

$members = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Team Members</h2>

<a href="create.php" class="btn btn-primary">
<i class="bi bi-plus-circle"></i>
Add Team Member
</a>

</div>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th width="90">Photo</th>

<th>Name</th>

<th>Designation</th>

<th>Email</th>

<th>Phone</th>

<th>Status</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

<?php if(count($members)): ?>

<?php foreach($members as $row): ?>

<tr>

<td>

<?php if(!empty($row['profile_image'])): ?>

<img
src="../../uploads/team/<?= $row['profile_image']; ?>"
width="70"
height="70"
style="object-fit:cover;border-radius:50%;">

<?php else: ?>

No Image

<?php endif; ?>

</td>

<td>

<?= htmlspecialchars($row['full_name']); ?>

</td>

<td>

<?= htmlspecialchars($row['designation']); ?>

</td>

<td>

<?= htmlspecialchars($row['email']); ?>

</td>

<td>

<?= htmlspecialchars($row['phone']); ?>

</td>

<td>

<?php if($row['status'] == 'Published'): ?>

<span class="btn btn-success btn-sm disabled">

Published

</span>

<?php else: ?>

<span class="btn btn-secondary btn-sm disabled">

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
onclick="return confirm('Delete this team member?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>

<td colspan="7" class="text-center">

No team members found.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

<?php include '../includes/footer.php'; ?>