<?php

$projects = getFeaturedPortfolio();

?>

<section class="py-5 bg-white">

<div class="container">

<div class="text-center mb-5">

<span class="text-primary fw-semibold">

PORTFOLIO

</span>

<h2 class="fw-bold mt-2">

Featured Projects

</h2>

<p class="text-muted">

Explore some of our latest architectural and interior design projects.

</p>

</div>

<div class="row g-4">

<?php foreach($projects as $project): ?>

<div class="col-lg-4 col-md-6">

<div class="card border-0 shadow-sm h-100">

<img
src="<?= imageUrl('portfolio', $project['thumbnail']); ?>"
class="card-img-top"
style="height:250px;object-fit:cover;"
alt="<?= e($project['title']); ?>">

<div class="card-body">

<h5 class="fw-bold">

<?= e($project['title']); ?>

</h5>

<p class="text-muted small mb-2">

<?= e($project['location']); ?>

</p>

<p>

<?= e($project['short_description']); ?>

</p>

<a
href="project-details.php?slug=<?= e($project['slug']); ?>"
class="btn btn-outline-primary btn-sm">

View Project

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<div class="text-center mt-5">

<a
href="portfolio.php"
class="btn btn-primary px-4">

View All Projects

</a>

</div>

</div>

</section>