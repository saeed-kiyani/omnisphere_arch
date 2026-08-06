<?php

/*
|--------------------------------------------------------------------------
| OmniSphere Architecture
| Services Page
|--------------------------------------------------------------------------
*/

require_once 'config/config.php';
require_once 'includes/functions.php';


/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = 'Our Services | ' . setting('company_name');

$metaDescription = 'Explore architectural design, interior design, exterior design, 3D visualization, landscape design, renovation and remodeling services by ' . setting('company_name');


/*
|--------------------------------------------------------------------------
| Fetch Published Services
|--------------------------------------------------------------------------
*/

$servicesStmt = $pdo->query("

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

    WHERE status = 'Published'

    ORDER BY id ASC

");

$services = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include 'includes/header.php';

include 'includes/navbar.php';

?>


<!-- =========================================================
     SERVICES HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">

                What We Do

            </span>


            <h1 class="os-section-title" style="color: #F5F7FA;">

                Our <span style="color: #B37D37">Services</span>

            </h1>


            <p class="os-section-description">

                From architectural design and interiors to
                3D visualization, landscaping and renovation,
                OmniSphere Architecture provides complete
                design solutions under one roof.

            </p>

        </div>

    </div>

</section>


<!-- =========================================================
     SERVICES GRID
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">


        <?php if (!empty($services)): ?>


            <div class="row g-4">


                <?php foreach ($services as $service): ?>

                    <?php

                    /*
                    |--------------------------------------------------------------------------
                    | Service Image
                    |--------------------------------------------------------------------------
                    */

                    $serviceImage = !empty($service['thumbnail'])
    ? upload('services/' . $service['thumbnail'])
    : asset('images/service-placeholder.g');


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
                    | Service URL
                    |--------------------------------------------------------------------------
                    */

                    $serviceUrl =
                        SITE_URL .
                        '/service-details.php?slug=' .
                        urlencode($service['slug']);

                    ?>


                    <div
                        class="col-lg-4 col-md-6"
                        data-aos="fade-up">


                        <article class="os-service-card">


                            <!-- Service Image -->

                            <a
                                href="<?= e($serviceUrl); ?>"
                                class="os-service-image">


                                <img
                                    src="<?= e($serviceImage); ?>"
                                    alt="<?= e($service['title']); ?>"
                                    loading="lazy">


                                <span class="os-service-image-overlay">

                                    <i class="bi bi-arrow-up-right"></i>

                                </span>


                            </a>


                            <!-- Service Content -->

                            <div class="os-service-content">


                                <!-- Icon -->

                                <div class="os-service-icon">

                                    <i class="<?= e($serviceIcon); ?>"></i>

                                </div>


                                <!-- Title -->

                                <h2 class="os-service-title">

                                    <a
                                        href="<?= e($serviceUrl); ?>">

                                        <?= e($service['title']); ?>

                                    </a>

                                </h2>


                                <!-- Description -->

                                <?php if (!empty($service['short_description'])): ?>

                                    <p class="os-service-description">

                                        <?= e($service['short_description']); ?>

                                    </p>

                                <?php elseif (!empty($service['description'])): ?>

                                    <p class="os-service-description">

                                        <?= e(
                                            mb_strimwidth(
                                                strip_tags($service['description']),
                                                0,
                                                150,
                                                '...'
                                            )
                                        ); ?>

                                    </p>

                                <?php endif; ?>


                                <!-- Link -->

                                <a
                                    href="<?= e($serviceUrl); ?>"
                                    class="os-service-link">

                                    Explore Service

                                    <i class="bi bi-arrow-right"></i>

                                </a>


                            </div>


                        </article>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- Empty State -->

            <div
                class="os-portfolio-empty"
                data-aos="fade-up">


                <div class="os-portfolio-empty-icon">

                    <i class="bi bi-tools"></i>

                </div>


                <h2>

                    Our Services Are Coming Soon

                </h2>


                <p>

                    We're currently preparing our service
                    information. Please check back soon.

                </p>


                <a
                    href="<?= SITE_URL; ?>/contact.php"
                    class="os-btn os-btn-primary">

                    Contact Us

                    <i class="bi bi-arrow-right"></i>

                </a>


            </div>


        <?php endif; ?>


    </div>

</section>

<?php include 'includes/footer.php'; ?>