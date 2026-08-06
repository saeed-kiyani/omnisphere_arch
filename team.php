<?php

/*
|--------------------------------------------------------------------------
| OmniSphere Architecture
| Team Page
|--------------------------------------------------------------------------
*/

require_once 'config/config.php';
require_once 'includes/functions.php';


/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = 'Our Team | ' . setting('company_name');

$metaDescription =
    'Meet the professional team behind ' .
    setting('company_name') .
    ' and discover the people shaping our architectural and design projects.';


/*
|--------------------------------------------------------------------------
| Fetch Team Members
|--------------------------------------------------------------------------
*/

$teamStmt = $pdo->query("

    SELECT

        id,
        full_name,
        designation,
        profile_image,
        bio,
        email,
        phone,
        linkedin,
        facebook,
        instagram,
        display_order,
        status,
        created_at,
        updated_at

    FROM team

    WHERE status = 'Published'

    ORDER BY
        display_order ASC,
        id ASC

");

$teamMembers = $teamStmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include 'includes/header.php';

include 'includes/navbar.php';

?>


<!-- =========================================================
     TEAM HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-page-hero-content"
            data-aos="fade-up">

            <span class="os-section-eyebrow">

                Our Team

            </span>

            <h1>

                Meet the People Behind Our Work

            </h1>

            <p>

                A dedicated team of architects, designers and
                creative professionals turning ideas into
                meaningful spaces.

            </p>

        </div>

    </div>

</section>


<!-- =========================================================
     TEAM MEMBERS
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">


        <!-- Section Header -->

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">

                The OmniSphere Team

            </span>

            <h2 class="os-section-title">

                Our Creative Professionals

            </h2>

            <p class="os-section-description">

                Meet the talented professionals who bring
                creativity, technical expertise and attention
                to detail to every project.

            </p>

        </div>


        <?php if (!empty($teamMembers)): ?>


            <div class="row g-4">


                <?php foreach ($teamMembers as $index => $member): ?>

                    <?php

                    /*
                    |--------------------------------------------------------------------------
                    | Profile Image
                    |--------------------------------------------------------------------------
                    */

                    $profileImage = !empty($member['profile_image'])

                        ? upload('team/' . $member['profile_image'])

                        : asset('images/team-placeholder.jpg');


                    /*
                    |--------------------------------------------------------------------------
                    | Bio
                    |--------------------------------------------------------------------------
                    */

                    $bio = trim($member['bio'] ?? '');

                    ?>


                    <div
                        class="col-xl-3 col-lg-4 col-md-6"
                        data-aos="fade-up"
                        data-aos-delay="<?= ($index % 4) * 100; ?>">


                        <article class="os-team-card">


                            <!-- Profile Image -->

                            <div class="os-team-image">

                                <img
                                    src="<?= e($profileImage); ?>"
                                    alt="<?= e($member['full_name']); ?>"
                                    loading="lazy">


                                <!-- Social Links -->

                                <?php

                                $hasSocials =
                                    !empty($member['linkedin']) ||
                                    !empty($member['facebook']) ||
                                    !empty($member['instagram']);

                                ?>

                                <?php if ($hasSocials): ?>

                                    <div class="os-team-socials">


                                        <?php if (!empty($member['linkedin'])): ?>

                                            <a
                                                href="<?= e($member['linkedin']); ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                aria-label="<?= e($member['full_name']); ?> LinkedIn">

                                                <i class="bi bi-linkedin"></i>

                                            </a>

                                        <?php endif; ?>


                                        <?php if (!empty($member['facebook'])): ?>

                                            <a
                                                href="<?= e($member['facebook']); ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                aria-label="<?= e($member['full_name']); ?> Facebook">

                                                <i class="bi bi-facebook"></i>

                                            </a>

                                        <?php endif; ?>


                                        <?php if (!empty($member['instagram'])): ?>

                                            <a
                                                href="<?= e($member['instagram']); ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                aria-label="<?= e($member['full_name']); ?> Instagram">

                                                <i class="bi bi-instagram"></i>

                                            </a>

                                        <?php endif; ?>


                                    </div>

                                <?php endif; ?>


                            </div>


                            <!-- Content -->

                            <div class="os-team-content">


                                <h3 class="os-team-name">

                                    <?= e($member['full_name']); ?>

                                </h3>


                                <?php if (!empty($member['designation'])): ?>

                                    <span class="os-team-designation">

                                        <?= e($member['designation']); ?>

                                    </span>

                                <?php endif; ?>


                                <?php if (!empty($bio)): ?>

    <?php
    $shortBio = mb_substr($bio, 0, 220);

    if (mb_strlen($bio) > 220) {
        $shortBio .= '...';
    }
    ?>

    <p class="os-team-bio">

        <?= e($shortBio); ?>

    </p>

    <a
        href="<?= SITE_URL; ?>/team-details.php?id=<?= (int) $member['id']; ?>"
        class="os-team-read-more">

        Read More

        <i class="bi bi-arrow-right"></i>

    </a>

<?php endif; ?>


                                <!-- Contact -->

                                <div class="os-team-contact">


                                    <?php if (!empty($member['email'])): ?>

                                        <a
                                            href="mailto:<?= e($member['email']); ?>">

                                            <i class="bi bi-envelope"></i>

                                            <span>

                                                <?= e($member['email']); ?>

                                            </span>

                                        </a>

                                    <?php endif; ?>


                                    <?php if (!empty($member['phone'])): ?>

                                        <a
                                            href="tel:<?= e($member['phone']); ?>">

                                            <i class="bi bi-telephone"></i>

                                            <span>

                                                <?= e($member['phone']); ?>

                                            </span>

                                        </a>

                                    <?php endif; ?>


                                </div>


                            </div>


                        </article>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php else: ?>


            <!-- Empty State -->

            <div
                class="os-team-empty"
                data-aos="fade-up">

                <div class="os-team-empty-icon">

                    <i class="bi bi-people"></i>

                </div>


                <h3>

                    Our Team Is Growing

                </h3>


                <p>

                    Our team information is currently being
                    updated. Please check back soon.

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