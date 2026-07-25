<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

$pageTitle = "Add Blog Category";

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="content">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Add Blog Category</h2>

<a href="index.php" class="btn btn-secondary">
Back
</a>

</div>

<form
action="store.php"
method="POST">

<!-- Category Title -->

<div class="mb-3">

<label class="form-label">

Category Title *

</label>

<input
type="text"
name="title"
id="title"
class="form-control"
required>

</div>

<!-- Slug -->

<div class="mb-3">

<label class="form-label">

Slug

</label>

<input
type="text"
name="slug"
id="slug"
class="form-control"
readonly>

</div>

<!-- Meta Title -->

<div class="mb-3">

<label class="form-label">

Meta Title

</label>

<input
type="text"
name="meta_title"
class="form-control">

</div>

<!-- Meta Description -->

<div class="mb-3">

<label class="form-label">

Meta Description

</label>

<textarea
name="meta_description"
class="form-control"
rows="4"></textarea>

</div>

<!-- Display Order -->

<div class="mb-3">

<label class="form-label">

Display Order

</label>

<input
type="number"
name="display_order"
class="form-control"
value="0">

</div>

<!-- Status -->

<div class="mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-control">

<option value="Published">

Published

</option>

<option value="Draft">

Draft

</option>

</select>

</div>

<button
type="submit"
class="btn btn-primary">

Save Category

</button>

<a
href="index.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

<script>

function slugify(text){

return text
.toLowerCase()
.trim()
.replace(/[^\w\s-]/g,'')
.replace(/\s+/g,'-')
.replace(/-+/g,'-');

}

document.getElementById("title").addEventListener("keyup",function(){

document.getElementById("slug").value=slugify(this.value);

});

</script>

<?php include '../includes/footer.php'; ?>