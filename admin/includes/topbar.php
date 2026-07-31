<div class="main-content">

<div class="topbar">

<div>

<h4 class="page-title"><?= $pageTitle ?></h4>

</div>

<div>

<?php

$hour = date('H');

if($hour < 12){

    $greeting = "Good Morning";

}elseif($hour < 17){

    $greeting = "Good Afternoon";

}else{

    $greeting = "Good Evening";

}

?>

<?= $greeting ?>,

<strong>OmniSphere Admin</strong>

</div>

</div>