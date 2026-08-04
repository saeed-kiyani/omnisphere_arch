<?php

/*
|--------------------------------------------------------------------------
| OmniSphere Architecture
| Service Details Page
|--------------------------------------------------------------------------
*/

require_once 'config/config.php';
require_once 'includes/functions.php';


/*
|--------------------------------------------------------------------------
| Get Service Slug
|--------------------------------------------------------------------------
*/

$slug = trim($_GET['slug'] ?? '');


/*
|--------------------------------------------------------------------------
| Validate Slug
|--------------------------------------------------------------------------
*/

if ($slug === '') {

    header('Location: ' . SITE_URL . '/services.php');

    exit;

}


/*
|--------------------------------------------------------------------------
| Fetch Service
|--------------------------------------------------------------------------
*/

$serviceStmt = $pdo->prepare("

    SELECT

        id,
        title,
        slug,
        short_description,
        description,
        meta_title,
        meta_description,
        icon,
        thumbnail,
        cover_image,
        featured,
        status,
        created_at,
        updated_at

    FROM services

    WHERE
        slug = :slug
        AND status = 'Published'

    LIMIT 1

");

$serviceStmt->execute([
    ':slug' => $slug
]);

$service = $serviceStmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Service Not Found
|--------------------------------------------------------------------------
*/

if (!$service) {

    http_response_code(404);

    $pageTitle = 'Service Not Found | ' . setting('company_name');

    $metaDescription = 'The requested service could not be found.';

    include 'includes/header.php';

    include 'includes/navbar.php';

    ?>

    <section class="os-section os-section-light">

        <div class="container">

            <div
                class="os-portfolio-empty"
                data-aos="fade-up">

                <div class="os-portfolio-empty-icon">

                    <i class="bi bi-exclamation-circle"></i>

                </div>

                <h1>
                    Service Not Found
                </h1>

                <p>
                    The service you are looking for is unavailable
                    or may have been removed.
                </p>

                <a
                    href="<?= SITE_URL; ?>/services.php"
                    class="os-btn os-btn-primary">

                    View All Services

                    <i class="bi bi-arrow-right"></i>

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
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = !empty($service['meta_title'])
    ? $service['meta_title']
    : $service['title'] . ' | ' . setting('company_name');


$metaDescription = !empty($service['meta_description'])
    ? $service['meta_description']
    : $service['short_description'];


/*
|--------------------------------------------------------------------------
| Service Cover Image
|--------------------------------------------------------------------------
*/

$coverImage = !empty($service['cover_image'])
    ? upload('services/' . $service['cover_image'])
    : (
        !empty($service['thumbnail'])
            ? upload('services/' . $service['thumbnail'])
            : asset('images/service-placeholder.jpg')
    );


/*
|--------------------------------------------------------------------------
| Service Icon
|--------------------------------------------------------------------------
*/

$serviceIcon = !empty($service['icon'])
    ? $service['icon']
    : 'bi bi-building';


/*
|--------------------------------------------------------------------------
| Related Portfolio Projects
|--------------------------------------------------------------------------
*/

$portfolioStmt = $pdo->prepare("

    SELECT

        p.id,
        p.title,
        p.slug,
        p.location,
        p.project_year,
        p.project_status,
        p.thumbnail,
        p.short_description,
        s.title AS service_title

    FROM portfolio p

    LEFT JOIN services s
        ON p.service_id = s.id

    WHERE

        p.service_id = :service_id

        AND p.status = 'Published'

    ORDER BY
        p.id DESC

    LIMIT 6

");

$portfolioStmt->execute([
    ':service_id' => $service['id']
]);

$relatedProjects = $portfolioStmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include 'includes/header.php';

include 'includes/navbar.php';

?>


<!-- =========================================================
     SERVICE HERO
========================================================= -->

<section
    class="os-service-detail-hero"
    style="background-image:
        linear-gradient(
            rgba(8, 25, 43, .68),
            rgba(8, 25, 43, .68)
        ),
        url('<?= e($coverImage); ?>');">

    <div class="container">

        <div
            class="os-service-detail-hero-content"
            data-aos="fade-up">


            <div class="os-service-detail-icon">

                <i class="<?= e($serviceIcon); ?>"></i>

            </div>


            <span class="os-section-eyebrow">

                Our Service

            </span>


            <h1 style="color: #F5F7FA;">

                <?= e($service['title']); ?>

            </h1>


            <?php if (!empty($service['short_description'])): ?>

                <p style="color: #F5F7FA;">

                    <?= e($service['short_description']); ?>

                </p>

            <?php endif; ?>


        </div>

    </div>

</section>


<!-- =========================================================
     SERVICE CONTENT
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <div class="row g-5 align-items-start">


            <!-- Main Content -->

            <div
                class="col-lg-8"
                data-aos="fade-up">


                <span class="os-section-eyebrow">

                    OmniSphere Architecture

                </span>


                <h2 class="os-section-title" style="color: #455123;">

                    <?= e($service['title']); ?>

                </h2>


                <?php if (!empty($service['description'])): ?>

                    <div class="os-service-detail-description" style="color: #08192B;">

                        <?= $service['description']; ?>

                    </div>

                <?php else: ?>

                    <p class="os-service-detail-description">

                        <?= e($service['short_description']); ?>

                    </p>

                <?php endif; ?>


            </div>


            <!-- Service Sidebar -->

            <div
                class="col-lg-4"
                data-aos="fade-up"
                data-aos-delay="100">


                <div class="os-service-detail-sidebar">


                    <div class="os-service-detail-sidebar-icon" style="color: #B37D37">

                        <i class="<?= e($serviceIcon); ?>"></i>

                    </div>


                    <h3 style="color: #455123">

                        Need This Service?

                    </h3>


                    <p>

                        Tell us about your project and our team
                        will help you develop the right design
                        solution.

                    </p>


                    <a
                        href="<?= SITE_URL; ?>/contact.php"
                        class="os-btn os-btn-primary w-100">

                        Start Your Project

                        <i class="bi bi-arrow-right"></i>

                    </a>


                    <a
                        href="https://wa.me/<?= preg_replace('/[^0-9]/', '', setting('whatsapp')); ?>"
                        target="_blank"
                        class="os-btn os-btn-outline w-100 mt-3">

                        <i class="bi bi-whatsapp"></i>

                        Discuss on WhatsApp

                    </a>


                </div>


            </div>


        </div>

    </div>

</section>


<!-- =========================================================
     RELATED PROJECTS
========================================================= -->

<?php if (!empty($relatedProjects)): ?>

<section class="os-section os-section-white">

    <div class="container">


        <!-- Section Header -->

        <div
            class="os-section-header"
            data-aos="fade-up">


            <span class="os-section-eyebrow">

                Our Work

            </span>


            <h2 class="os-section-title" style="color: #455123">

                Related Projects

            </h2>


            <p class="os-section-description">

                Explore selected projects related to
                <?= e($service['title']); ?>.

            </p>


        </div>


        <!-- Projects -->

        <div class="row g-4">


            <?php foreach ($relatedProjects as $project): ?>

                <?php

                $projectImage = !empty($project['thumbnail'])
                    ? upload('portfolio/' . $project['thumbnail'])
                    : asset('images/portfolio-placeholder.jpg');

                $projectUrl =
                    SITE_URL .
                    '/project-details.php?slug=' .
                    urlencode($project['slug']);

                ?>


                <div
                    class="col-lg-4 col-md-6"
                    data-aos="fade-up">


                    <article class="os-portfolio-card">


                        <!-- Image -->

                        <a
                            href="<?= e($projectUrl); ?>"
                            class="os-portfolio-image">

                            <img
                                src="<?= e($projectImage); ?>"
                                alt="<?= e($project['title']); ?>"
                                loading="lazy">

                            <span class="os-portfolio-overlay">

                                <i class="bi bi-arrow-up-right"></i>

                            </span>

                        </a>


                        <!-- Content -->

                        <div class="os-portfolio-content">


                            <?php if (!empty($project['service_title'])): ?>

                                <span class="os-portfolio-category">

                                    <?= e($project['service_title']); ?>

                                </span>

                            <?php endif; ?>


                            <h3 class="os-portfolio-title">

                                <a
                                    href="<?= e($projectUrl); ?>">

                                    <?= e($project['title']); ?>

                                </a>

                            </h3>


                            <?php if (!empty($project['short_description'])): ?>

                                <p class="os-portfolio-description">

                                    <?= e($project['short_description']); ?>

                                </p>

                            <?php endif; ?>


                            <div class="os-portfolio-meta">


                                <?php if (!empty($project['location'])): ?>

                                    <span>

                                        <i class="bi bi-geo-alt me-1"></i>

                                        <?= e($project['location']); ?>

                                    </span>

                                <?php endif; ?>


                                <?php if (!empty($project['project_year'])): ?>

                                    <span>

                                        <i class="bi bi-calendar3 me-1"></i>

                                        <?= e($project['project_year']); ?>

                                    </span>

                                <?php endif; ?>


                            </div>


                            <a
                                href="<?= e($projectUrl); ?>"
                                class="os-portfolio-link">

                                View Project

                                <i class="bi bi-arrow-right"></i>

                            </a>


                        </div>


                    </article>


                </div>


            <?php endforeach; ?>


        </div>


        <div
            class="text-center mt-5"
            data-aos="fade-up">


            <a
                href="<?= SITE_URL; ?>/portfolio.php"
                class="os-btn os-btn-outline">

                View All Projects

                <i class="bi bi-arrow-right"></i>

            </a>


        </div>


    </div>

</section>

<?php endif; ?>


<!-- =========================================================
     FINAL CTA
========================================================= -->

<section class="os-section os-section-dark">

    <div class="container">

        <div
            class="os-section-header"
            data-aos="fade-up">


            <span class="os-section-eyebrow">

                Let's Work Together

            </span>


            <h2 class="os-section-title" style="color: #F5F7FA">

                Ready to Start Your Project?

            </h2>


            <p class="os-section-description">

                From concept to completion, OmniSphere
                Architecture is ready to bring your vision
                to life.

            </p>


            <div class="mt-4">


                <a
                    href="<?= SITE_URL; ?>/contact.php"
                    class="os-btn os-btn-primary">

                    Contact Us

                    <i class="bi bi-arrow-right"></i>

                </a>


            </div>


        </div>

    </div>

</section>


<?php include 'includes/footer.php'; ?>