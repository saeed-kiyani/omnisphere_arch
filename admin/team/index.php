<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

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

<h3>Team Members</h3>

<a href="create.php" class="btn btn-primary add-btn">
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

<table class="table table-bordered table-hover align-middle">

<thead class="table text-center">

<tr class="thead-row">

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

<button
type="button"
class="btn btn-info btn-sm viewMember"

data-bs-toggle="modal"
data-bs-target="#viewTeamModal"

data-member='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8"); ?>'>

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
onclick="return confirm('Delete this team member?')">

<i class="bi bi-trash"></i>

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


<div class="modal fade" id="viewTeamModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Team Member Details
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <!-- Photo -->

                    <div class="col-md-4 text-center">

                        <img
                            id="memberPhoto"
                            class="img-fluid rounded-circle shadow"
                            style="
                                width:220px;
                                height:220px;
                                object-fit:cover;
                            ">

                    </div>

                    <!-- Details -->

                    <div class="col-md-8">

                        <table class="table table-bordered align-middle">

                            <tr>
                                <th width="180">Full Name</th>
                                <td id="memberName"></td>
                            </tr>

                            <tr>
                                <th>Designation</th>
                                <td id="memberDesignation"></td>
                            </tr>

                            <tr>

                                <th>Bio</th>

                                <td>

                                    <div
                                        id="memberBio"
                                        style="
                                            max-height:220px;
                                            overflow-y:auto;
                                        ">
                                    </div>

                                </td>

                            </tr>

                            <tr>
                                <th>Email</th>
                                <td id="memberEmail"></td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td id="memberPhone"></td>
                            </tr>

                            <tr>
                                <th>LinkedIn</th>
                                <td id="memberLinkedin"></td>
                            </tr>

                            <tr>
                                <th>Facebook</th>
                                <td id="memberFacebook"></td>
                            </tr>

                            <tr>
                                <th>Instagram</th>
                                <td id="memberInstagram"></td>
                            </tr>

                            <tr>
                                <th>Display Order</th>
                                <td id="memberOrder"></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td id="memberStatus"></td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.querySelectorAll('.viewMember').forEach(button => {

button.addEventListener('click', function(){

const member = JSON.parse(this.dataset.member);

document.getElementById('memberPhoto').src =
member.profile_image
? '../../uploads/team/' + member.profile_image
: '../../assets/images/no-image.png';

document.getElementById('memberName').innerText =
member.full_name || '-';

document.getElementById('memberDesignation').innerText =
member.designation || '-';

document.getElementById('memberBio').innerHTML =
member.bio || '-';

document.getElementById('memberEmail').innerText =
member.email || '-';

document.getElementById('memberPhone').innerText =
member.phone || '-';

document.getElementById('memberLinkedin').innerHTML =
member.linkedin
? '<a href="' + member.linkedin + '" target="_blank">' + member.linkedin + '</a>'
: '-';

document.getElementById('memberFacebook').innerHTML =
member.facebook
? '<a href="' + member.facebook + '" target="_blank">' + member.facebook + '</a>'
: '-';

document.getElementById('memberInstagram').innerHTML =
member.instagram
? '<a href="' + member.instagram + '" target="_blank">' + member.instagram + '</a>'
: '-';

document.getElementById('memberOrder').innerText =
member.display_order;

document.getElementById('memberStatus').innerHTML =
member.status === 'Published'
? '<span class="badge bg-success">Published</span>'
: '<span class="badge bg-secondary">Draft</span>';

});

});

</script>

<?php include '../includes/footer.php'; ?>