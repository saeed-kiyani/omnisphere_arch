<?php

/*
|--------------------------------------------------------------------------
| OmniSphere Architecture
| Team Member Details Page
|--------------------------------------------------------------------------
*/

require_once 'config/config.php';
require_once 'includes/functions.php';


/*
|--------------------------------------------------------------------------
| Get Team Member ID
|--------------------------------------------------------------------------
*/

$memberId = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;

if ($memberId <= 0) {

    header('Location: ' . SITE_URL . '/team.php');
    exit;

}


/*
|--------------------------------------------------------------------------
| Fetch Team Member
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
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
        instagram
    FROM team
    WHERE id = ?
      AND status = 'Published'
    LIMIT 1
");

$stmt->execute([$memberId]);

$member = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Member Not Found
|--------------------------------------------------------------------------
*/

if (!$member) {

    header('Location: ' . SITE_URL . '/team.php');
    exit;

}


/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle =
    $member['full_name'] .
    ' | ' .
    setting('company_name');

$metaDescription =
    !empty($member['bio'])
        ? mb_substr(
            trim($member['bio']),
            0,
            160
        )
        : 'Meet ' .
          $member['full_name'] .
          ' at ' .
          setting('company_name');


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
| Header
|--------------------------------------------------------------------------
*/

include 'includes/header.php';

include 'includes/navbar.php';

?>


<!-- =========================================================
     TEAM MEMBER HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-page-hero-content"
            data-aos="fade-up">

            <span class="os-section-eyebrow">

                <?= e($member['designation']); ?>

            </span>

            <h1>

                <?= e($member['full_name']); ?>

            </h1>

            <p>

                Meet <?= e($member['full_name']); ?> and
                discover their role at
                <?= e(setting('company_name')); ?>.

            </p>

        </div>

    </div>

</section>


<!-- =========================================================
     TEAM MEMBER DETAILS
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <div class="row g-5 align-items-start">


            <!-- Profile Image -->

            <div
                class="col-lg-5"
                data-aos="fade-right">

                <div class="os-team-details-image">

                    <img
                        src="<?= e($profileImage); ?>"
                        alt="<?= e($member['full_name']); ?>"
                        loading="lazy">

                </div>

            </div>


            <!-- Profile Content -->

            <div
                class="col-lg-7"
                data-aos="fade-left">

                <span class="os-section-eyebrow">

                    <?= e($member['designation']); ?>

                </span>

                <h2 class="os-section-title">

                    <?= e($member['full_name']); ?>

                </h2>


                <?php if (!empty($member['bio'])): ?>

                    <div class="os-team-details-bio">

                        <?= nl2br(e($member['bio'])); ?>

                    </div>

                <?php endif; ?>


                <!-- Contact -->

                <div class="os-team-details-contact mt-4">


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


                <!-- Social Links -->

                <div class="os-team-details-socials mt-4">


                    <?php if (!empty($member['linkedin'])): ?>

                        <a
                            href="<?= e($member['linkedin']); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="LinkedIn">

                            <i class="bi bi-linkedin"></i>

                        </a>

                    <?php endif; ?>


                    <?php if (!empty($member['facebook'])): ?>

                        <a
                            href="<?= e($member['facebook']); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook">

                            <i class="bi bi-facebook"></i>

                        </a>

                    <?php endif; ?>


                    <?php if (!empty($member['instagram'])): ?>

                        <a
                            href="<?= e($member['instagram']); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram">

                            <i class="bi bi-instagram"></i>

                        </a>

                    <?php endif; ?>


                </div>


                <!-- Back Button -->

                <div class="mt-4">

                    <a
                        href="<?= SITE_URL; ?>/team.php"
                        class="os-btn os-btn-primary">

                        <i class="bi bi-arrow-left"></i>

                        Back to Team

                    </a>

                </div>


            </div>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>