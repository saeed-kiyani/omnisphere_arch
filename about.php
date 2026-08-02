<?php

require_once 'config/config.php';
require_once 'includes/functions.php';

$pageTitle = 'About Us | ' . setting('company_name');

$metaDescription = 'Learn more about ' . setting('company_name') . ', our architectural approach, values, services and commitment to creating meaningful spaces.';

include 'includes/header.php';
include 'includes/navbar.php';

?>

<?php include 'includes/about/hero.php'; ?>

<?php include 'includes/about/story.php'; ?>

<?php include 'includes/about/mission-vision.php'; ?>

<?php include 'includes/about/values.php'; ?>

<?php include 'includes/about/cta.php'; ?>

<?php include 'includes/footer.php'; ?>