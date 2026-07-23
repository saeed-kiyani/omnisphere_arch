<?php

if (!isset($_SESSION['admin_id'])) {

    redirect('login.php');

}