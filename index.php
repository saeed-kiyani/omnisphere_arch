<?php

require_once 'config/config.php';
require_once 'includes/functions.php';

$pageTitle = pageTitle();

include 'includes/header.php';
include 'includes/navbar.php';

?>

<!-- Hero -->
<?php include 'includes/home/hero.php'; ?>

<!-- About -->
<?php include 'includes/home/about.php'; ?>

<!-- Featured Services -->
<?php include 'includes/home/services.php'; ?>

<!-- Featured Portfolio -->
<?php include 'includes/home/portfolio.php'; ?>

<!-- Why Choose Us -->
<?php include 'includes/home/why-choose-us.php'; ?>

<!-- Team -->
<?php include 'includes/home/team.php'; ?>

<!-- Testimonials -->
<?php include 'includes/home/testimonials.php'; ?>

<!-- Latest Blogs -->
<?php include 'includes/home/blog.php'; ?>

<!-- Call To Action -->
<?php include 'includes/home/cta.php'; ?>

<?php include 'includes/footer.php'; ?>