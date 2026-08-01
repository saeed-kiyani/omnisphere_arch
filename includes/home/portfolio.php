<?php

/*
|--------------------------------------------------------------------------
| Featured Portfolio Projects
|--------------------------------------------------------------------------
| Homepage shows only published + featured projects.
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

    WHERE
        p.status = 'Published'
        AND p.featured = 1

    ORDER BY
        p.id DESC

    LIMIT 3
");

$featuredPortfolio = $portfolioStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- =========================================================
     FEATURED PORTFOLIO
========================================================= -->

<section
    class="os-section os-section-light"
    id="featured-portfolio">

    <div class="container">

        <!-- Section Header -->

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                Our Portfolio
            </span>

            <h2 class="os-section-title">
                Selected Projects
            </h2>

            <p class="os-section-description">

                Explore a selection of architectural,
                interior and design projects created
                by OmniSphere Architecture.

            </p>

        </div>


        <?php if (!empty($featuredPortfolio)): ?>

            <div class="row g-4">

                <?php foreach ($featuredPortfolio as $project): ?>

                    <?php

                    /*
                    |--------------------------------------------------------------------------
                    | Project Image
                    |--------------------------------------------------------------------------
                    */

                    $projectImage = !empty($project['thumbnail'])
                        ? upload('portfolio/' . $project['thumbnail'])
                        : asset('images/portfolio-placeholder.jpg');

                    ?>


                    <div
                        class="col-lg-4 col-md-6"
                        data-aos="fade-up">

                        <article class="os-portfolio-card">


                            <!-- Project Image -->

                            <a
                                href="<?= SITE_URL; ?>/project-details.php?slug=<?= urlencode($project['slug']); ?>"
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


                                <h3 class="os-portfolio-title">

                                    <a
                                        href="<?= SITE_URL; ?>/project-details.php?slug=<?= urlencode($project['slug']); ?>">

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
                                    href="<?= SITE_URL; ?>/project-details.php?slug=<?= urlencode($project['slug']); ?>"
                                    class="os-portfolio-link">

                                    View Project

                                    <i class="bi bi-arrow-right"></i>

                                </a>


                            </div>

                        </article>

                    </div>

                <?php endforeach; ?>

            </div>


            <!-- View All Portfolio -->

            <div
                class="text-center mt-5"
                data-aos="fade-up">

                <a
                    href="<?= SITE_URL; ?>/portfolio.php"
                    class="os-btn os-btn-primary">

                    View All Projects

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


        <?php else: ?>


            <!-- Empty State -->

            <div
                class="os-portfolio-empty"
                data-aos="fade-up">

                <div class="os-portfolio-empty-icon">

                    <i class="bi bi-building"></i>

                </div>

                <h3>
                    Our Portfolio Is Coming Soon
                </h3>

                <p>
                    We're currently preparing our featured
                    projects. Please check back soon.
                </p>

            </div>


        <?php endif; ?>

    </div>

</section>