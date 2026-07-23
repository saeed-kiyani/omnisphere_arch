<?php

require_once '../config/config.php';
require_once 'includes/auth-check.php';

$pageTitle = "Dashboard";

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/topbar.php';

?>

<div class="content">

<div class="row">

<div class="col-md-3">

<div class="card">

<div class="card-body">

<h5>Projects</h5>

<h2>0</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body">

<h5>Services</h5>

<h2>0</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body">

<h5>Blogs</h5>

<h2>0</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card">

<div class="card-body">

<h5>Leads</h5>

<h2>0</h2>

</div>

</div>

</div>

</div>

</div>

<?php

include 'includes/footer.php';

?>