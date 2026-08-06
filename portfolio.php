<?php

/*
|--------------------------------------------------------------------------
| OmniSphere Architecture
| Full Portfolio Page
|--------------------------------------------------------------------------
*/

require_once 'config/config.php';
require_once 'includes/functions.php';

/*
|--------------------------------------------------------------------------
| Page SEO
|--------------------------------------------------------------------------
*/

$pageTitle = 'Portfolio | ' . setting('company_name');

$metaDescription = 'Explore architectural, interior, exterior, landscape, renovation and 3D visualization projects by OmniSphere Architecture.';

$metaKeywords = 'OmniSphere Architecture, architecture portfolio, architectural design, interior design, exterior design, 3D visualization, landscape design, renovation';

/*
|--------------------------------------------------------------------------
| Fetch Published Portfolio Projects
|--------------------------------------------------------------------------
*/

$portfolioStmt = $pdo->query("
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

    WHERE p.status = 'Published'

    ORDER BY p.id DESC
");

$portfolioProjects = $portfolioStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/navbar.php'; ?>


<!-- =========================================================
     PORTFOLIO HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                Our Portfolio
            </span>

            <h1 class="os-section-title" style="color: #F5F7FA;">
                Our <span style="color: #B37D37">Projects</span>
            </h1>

            <p class="os-section-description">

                Explore our collection of architectural,
                interior, exterior, landscape and
                visualization projects created by
                OmniSphere Architecture.

            </p>

        </div>

    </div>

</section>


<!-- =========================================================
     PORTFOLIO PROJECTS
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <?php if (!empty($portfolioProjects)): ?>

            <div class="row g-4">

                <?php foreach ($portfolioProjects as $project): ?>

                    <?php

                    /*
                    |--------------------------------------------------------------------------
                    | Project Image
                    |--------------------------------------------------------------------------
                    */

                    $projectImage = !empty($project['thumbnail'])
                        ? upload('portfolio/' . $project['thumbnail'])
                        : asset('images/portfolio-placeholder.jpg');

                    /*
                    |--------------------------------------------------------------------------
                    | Project URL
                    |--------------------------------------------------------------------------
                    */

                    $projectUrl =
                        SITE_URL .
                        '/project-details.php?slug=' .
                        urlencode($project['slug']);

                    ?>

                    <div
                        class="col-lg-4 col-md-6"
                        data-aos="fade-up">

                        <article class="os-portfolio-card">


                            <!-- Project Image -->

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


                            <!-- Project Content -->

                            <div class="os-portfolio-content">


                                <?php if (!empty($project['service_title'])): ?>

                                    <span class="os-portfolio-category">

                                        <?= e($project['service_title']); ?>

                                    </span>

                                <?php endif; ?>


                                <h2 class="os-portfolio-title">

                                    <a
                                        href="<?= e($projectUrl); ?>">

                                        <?= e($project['title']); ?>

                                    </a>

                                </h2>


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


        <?php else: ?>


            <!-- =================================================
                 EMPTY PORTFOLIO STATE
            ================================================= -->

            <div
                class="os-portfolio-empty"
                data-aos="fade-up">

                <div class="os-portfolio-empty-icon">

                    <i class="bi bi-building"></i>

                </div>

                <h2>

                    Projects Coming Soon

                </h2>

                <p>

                    We're currently preparing our
                    portfolio. Please check back soon.

                </p>

            </div>


        <?php endif; ?>

    </div>

</section>

<?php include 'includes/footer.php'; ?>