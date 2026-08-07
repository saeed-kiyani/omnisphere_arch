<?php

/*
|--------------------------------------------------------------------------
| OmniSphere Architecture
| Project Details Page
|--------------------------------------------------------------------------
*/

require_once 'config/config.php';
require_once 'includes/functions.php';


/*
|--------------------------------------------------------------------------
| Get Project Slug
|--------------------------------------------------------------------------
*/

$slug = trim($_GET['slug'] ?? '');


/*
|--------------------------------------------------------------------------
| Function: Render Project Not Found
|--------------------------------------------------------------------------
*/

function renderProjectNotFound()
{
    http_response_code(404);

    global $settings;

    $pageTitle = 'Project Not Found | ' . setting('company_name');

    include 'includes/header.php';
    include 'includes/navbar.php';

    ?>

    <!-- =========================================================
         PROJECT NOT FOUND
    ========================================================= -->

    <section class="os-section os-section-light">

        <div class="container">

            <div
                class="os-portfolio-empty"
                data-aos="fade-up">

                <div class="os-portfolio-empty-icon">

                    <i class="bi bi-building-x"></i>

                </div>

                <h1>
                    Project Not Found
                </h1>

                <p>
                    The project you're looking for could not be found,
                    may have been unpublished, or the URL may be incorrect.
                </p>

                <a
                    href="<?= SITE_URL; ?>/portfolio.php"
                    class="os-btn os-btn-primary">

                    <i class="bi bi-arrow-left me-2"></i>

                    Back to Portfolio

                </a>

            </div>

        </div>

    </section>

    <?php

    include 'includes/footer.php';

    exit;
}


/*
|--------------------------------------------------------------------------
| Validate Slug
|--------------------------------------------------------------------------
*/

if ($slug === '') {

    renderProjectNotFound();

}


/*
|--------------------------------------------------------------------------
| Fetch Project
|--------------------------------------------------------------------------
*/

$projectStmt = $pdo->prepare("

    SELECT

        p.id,
        p.service_id,
        p.title,
        p.slug,
        p.client_name,
        p.location,
        p.project_year,
        p.project_area,
        p.project_status,
        p.thumbnail,
        p.short_description,
        p.description,
        p.meta_title,
        p.meta_description,
        p.featured,
        p.status,
        p.created_at,
        p.updated_at,

        s.title AS service_title

    FROM portfolio p

    LEFT JOIN services s
        ON p.service_id = s.id

    WHERE
        p.slug = ?
        AND p.status = 'Published'

    LIMIT 1

");

$projectStmt->execute([$slug]);

$project = $projectStmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Project Not Found
|--------------------------------------------------------------------------
*/

if (!$project) {

    renderProjectNotFound();

}


/*
|--------------------------------------------------------------------------
| Fetch Project Gallery
|--------------------------------------------------------------------------
*/

$galleryStmt = $pdo->prepare("

    SELECT

        id,
        portfolio_id,
        image,
        alt_text,
        display_order,
        created_at

    FROM portfolio_images

    WHERE portfolio_id = ?

    ORDER BY
        display_order ASC,
        id ASC

");

$galleryStmt->execute([
    $project['id']
]);

$projectImages = $galleryStmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = !empty($project['meta_title'])
    ? $project['meta_title']
    : $project['title'] . ' | ' . setting('company_name');


$metaDescription = !empty($project['meta_description'])
    ? $project['meta_description']
    : $project['short_description'];


/*
|--------------------------------------------------------------------------
| Main Project Image
|--------------------------------------------------------------------------
*/

$projectImage = !empty($project['thumbnail'])
    ? upload('portfolio/' . $project['thumbnail'])
    : asset('images/portfolio-placeholder.jpg');


/*
|--------------------------------------------------------------------------
| Main Image Alt
|--------------------------------------------------------------------------
*/

$projectImageAlt = $project['title'];

?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/navbar.php'; ?>


<!-- =========================================================
     PROJECT HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-section-header"
            data-aos="fade-up">


            <?php if (!empty($project['service_title'])): ?>

                <span class="os-section-eyebrow" style="color: #F5F7FA;">

                    <?= e($project['service_title']); ?>

                </span>

            <?php endif; ?>


            <h1 class="os-section-title" style="
    background: linear-gradient(90deg, #455123 0%, #B37D37 45%, #F5F7FA 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    color: transparent;
  ">

                <?= e($project['title']); ?>

            </h1>


            <?php if (!empty($project['short_description'])): ?>

                <p class="os-section-description" style="color: #F5F7FA;">

                    <?= e($project['short_description']); ?>

                </p>

            <?php endif; ?>

        </div>

    </div>

</section>


<!-- =========================================================
     PROJECT OVERVIEW
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <div class="row g-5 align-items-start">


            <!-- =================================================
                 MAIN PROJECT IMAGE
            ================================================= -->

            <div
                class="col-lg-7"
                data-aos="fade-right">

                <a
                    href="<?= e($projectImage); ?>"
                    class="os-project-detail-image glightbox"
                    data-gallery="project-gallery"
                    data-title="<?= e($project['title']); ?>">

                    <img
                        src="<?= e($projectImage); ?>"
                        alt="<?= e($projectImageAlt); ?>"
                        class="img-fluid"
                        loading="eager">

                    <span class="os-project-image-zoom">

                        <i class="bi bi-arrows-fullscreen"></i>

                    </span>

                </a>

            </div>


            <!-- =================================================
                 PROJECT INFORMATION
            ================================================= -->

            <div
                class="col-lg-5"
                data-aos="fade-left">

                <div class="os-project-info">


                    <span class="os-section-eyebrow">

                        Project Information

                    </span>


                    <h2 class="os-project-info-title" style="color: #455123;">

                        <?= e($project['title']); ?>

                    </h2>


                    <?php if (!empty($project['description'])): ?>

                        <div class="os-project-description" style="color: #08192B;">

                            <?= nl2br(e($project['description'])); ?>

                        </div>

                    <?php endif; ?>


                    <!-- Project Metadata -->

                    <div class="os-project-meta">


                        <?php if (!empty($project['service_title'])): ?>

                            <div class="os-project-meta-item">

                                <i class="bi bi-grid"></i>

                                <div>

                                    <small>
                                        Service
                                    </small>

                                    <strong>

                                        <?= e($project['service_title']); ?>

                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                        <?php if (!empty($project['client_name'])): ?>

                            <div class="os-project-meta-item">

                                <i class="bi bi-person"></i>

                                <div>

                                    <small>
                                        Client
                                    </small>

                                    <strong>

                                        <?= e($project['client_name']); ?>

                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                        <?php if (!empty($project['location'])): ?>

                            <div class="os-project-meta-item">

                                <i class="bi bi-geo-alt"></i>

                                <div>

                                    <small>
                                        Location
                                    </small>

                                    <strong>

                                        <?= e($project['location']); ?>

                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                        <?php if (!empty($project['project_year'])): ?>

                            <div class="os-project-meta-item">

                                <i class="bi bi-calendar3"></i>

                                <div>

                                    <small>
                                        Year
                                    </small>

                                    <strong>

                                        <?= e($project['project_year']); ?>

                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                        <?php if (!empty($project['project_area'])): ?>

                            <div class="os-project-meta-item">

                                <i class="bi bi-rulers"></i>

                                <div>

                                    <small>
                                        Project Area
                                    </small>

                                    <strong>

                                        <?= e($project['project_area']); ?>

                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                        <?php if (!empty($project['project_status'])): ?>

                            <div class="os-project-meta-item">

                                <i class="bi bi-check-circle"></i>

                                <div>

                                    <small>
                                        Status
                                    </small>

                                    <strong>

                                        <?= e($project['project_status']); ?>

                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                    </div>


                    <!-- CTA -->

                    <div class="mt-4">

                        <a
                            href="<?= SITE_URL; ?>/contact.php"
                            class="os-btn os-btn-primary">

                            Discuss Your Project

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     PROJECT GALLERY
========================================================= -->

<?php if (!empty($projectImages)): ?>

<section class="os-section os-section-white">

    <div class="container">


        <!-- Gallery Header -->

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">

                Project Gallery

            </span>

            <h2 class="os-section-title" style="color: #455123">

                Explore the Project

            </h2>

            <p class="os-section-description">

                Take a closer look at the design,
                details and spaces of this project.

            </p>

        </div>


        <!-- Gallery Grid -->

        <div class="row g-4">


            <?php foreach ($projectImages as $image): ?>

                <?php

                $galleryImage = !empty($image['image'])
                    ? upload('portfolio/' . $image['image'])
                    : asset('images/portfolio-placeholder.jpg');


                $galleryAlt = !empty($image['alt_text'])
                    ? $image['alt_text']
                    : $project['title'];

                ?>


                <div
                    class="col-lg-4 col-md-6"
                    data-aos="fade-up">


                    <a
                        href="<?= e($galleryImage); ?>"
                        class="os-project-gallery-item glightbox"
                        data-gallery="project-gallery"
                        data-title="<?= e($galleryAlt); ?>">


                        <img
                            src="<?= e($galleryImage); ?>"
                            alt="<?= e($galleryAlt); ?>"
                            loading="lazy">


                        <span class="os-project-gallery-overlay">

                            <i class="bi bi-arrows-fullscreen"></i>

                        </span>


                    </a>

                </div>


            <?php endforeach; ?>


        </div>

    </div>

</section>

<?php endif; ?>


<!-- =========================================================
     BACK TO PORTFOLIO
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <div
            class="text-center"
            data-aos="fade-up">

            <a
                href="<?= SITE_URL; ?>/portfolio.php"
                class="os-btn os-btn-secondary" style="color: #B37D37;">

                <i class="bi bi-arrow-left me-2"></i>

                Back to Portfolio

            </a>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>