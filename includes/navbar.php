<?php

$settings = getSettings();

$logo = !empty($settings['logo'])
    ? upload('settings/' . $settings['logo'])
    : asset('images/logo.png');

?>

<!-- ===========================
Navbar Start
=========================== -->

<nav
    class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top os-navbar"
    id="mainNavigation"
>

    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="<?= SITE_URL; ?>">

            <img
                src="<?= $logo; ?>"
                alt="<?= e($settings['company_name']); ?>"
                class="navbar-logo me-2">

            <div>

                <strong>

                    <?= e($settings['company_name']); ?>

                </strong>

                <small class="d-block text-muted">

                    <?= e($settings['tagline']); ?>

                </small>

            </div>

        </a>

        <button
    class="navbar-toggler"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#mainNavbar"
    aria-controls="mainNavbar"
    aria-expanded="false"
    aria-label="Toggle navigation"
>
    <span class="navbar-toggler-icon"></span>
</button>

        <div
            class="collapse navbar-collapse"
            id="mainNavbar">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage('index.php'); ?>"
                        href="<?= SITE_URL; ?>">

                        Home

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage('about.php'); ?>"
                        href="<?= SITE_URL; ?>/about.php">

                        About

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage([
    'services.php',
    'service-details.php'
]); ?>"
                        href="<?= SITE_URL; ?>/services.php">

                        Services

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage([
    'portfolio.php',
    'project-details.php'
]); ?>"
                        href="<?= SITE_URL; ?>/portfolio.php">

                        Portfolio

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage([
    'blog.php',
    'blog-details.php'
]); ?>"
                        href="<?= SITE_URL; ?>/blog.php">

                        Blog

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage('team.php'); ?>"
                        href="<?= SITE_URL; ?>/team.php">

                        Team

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        class="nav-link <?= isActivePage('contact.php'); ?>"
                        href="<?= SITE_URL; ?>/contact.php">

                        Contact

                    </a>

                </li>

                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">

                    <a
    href="https://wa.me/<?= preg_replace('/[^0-9]/', '', setting('whatsapp')); ?>"
    target="_blank"
    rel="noopener noreferrer"
    class="btn btn-primary os-navbar-cta"
>

                        <i class="bi bi-whatsapp me-2"></i>

                        Get a Quote

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>

<!-- ===========================
Navbar End
=========================== -->