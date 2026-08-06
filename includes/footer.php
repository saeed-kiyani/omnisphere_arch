<?php

$settings = getSettings();

$logo = !empty($settings['logo'])
    ? upload('settings/' . $settings['logo'])
    : asset('images/logo.png');

?>

<!-- =========================================================
     FOOTER CTA
========================================================= -->

<section class="footer-cta">

    <div class="container">

        <div class="footer-cta-inner">

            <div class="footer-cta-content">

                <span class="footer-cta-label">
                    LET'S BUILD SOMETHING GREAT
                </span>

                <h2>
                    Have a project in mind?
                </h2>

                <p>
                    Let's turn your architectural vision into a space
                    that's designed to inspire, built to last, and made
                    for you.
                </p>

            </div>

            <div class="footer-cta-action">

                <a
                    href="<?= SITE_URL; ?>/contact.php"
                    class="footer-cta-btn"
                >
                    Start Your Project
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     MAIN FOOTER
========================================================= -->

<footer class="site-footer">

    <div class="container">

        <div class="row gy-5">


            <!-- =================================================
                 BRAND
            ================================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="footer-brand">

                    <a
                        href="<?= SITE_URL; ?>"
                        class="footer-brand-link"
                    >

                        <img
                            src="<?= $logo; ?>"
                            alt="<?= e($settings['company_name']); ?>"
                            class="footer-logo"
                        >

                    </a>


                    <h3>
                        <?= e($settings['company_name']); ?>
                    </h3>


                    <p class="footer-tagline">
                        <?= e($settings['tagline']); ?>
                    </p>


                    <p class="footer-description">

                        We create thoughtful architectural designs,
                        inspiring interiors, distinctive exteriors,
                        and realistic 3D visualizations that transform
                        ideas into extraordinary spaces.

                    </p>


                    <!-- Social Icons -->

                    <div class="footer-socials">

                        <?php if(!empty($settings['facebook'])): ?>

                            <a
                                href="<?= e($settings['facebook']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Facebook"
                            >
                                <i class="bi bi-facebook"></i>
                            </a>

                        <?php endif; ?>


                        <?php if(!empty($settings['instagram'])): ?>

                            <a
                                href="<?= e($settings['instagram']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Instagram"
                            >
                                <i class="bi bi-instagram"></i>
                            </a>

                        <?php endif; ?>


                        <?php if(!empty($settings['linkedin'])): ?>

                            <a
                                href="<?= e($settings['linkedin']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="LinkedIn"
                            >
                                <i class="bi bi-linkedin"></i>
                            </a>

                        <?php endif; ?>


                        <?php if(!empty($settings['youtube'])): ?>

                            <a
                                href="<?= e($settings['youtube']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="YouTube"
                            >
                                <i class="bi bi-youtube"></i>
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 QUICK LINKS
            ================================================== -->

            <div class="col-lg-2 col-md-6">

                <div class="footer-column">

                    <h5>
                        Quick Links
                    </h5>

                    <ul class="footer-links">

                        <li>
                            <a href="<?= SITE_URL; ?>/">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/about.php">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                Services
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/portfolio.php">
                                Portfolio
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/blog.php">
                                Blog
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/team.php">
                                Our Team
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/contact.php">
                                Contact
                            </a>
                        </li>

                    </ul>

                </div>

            </div>



            <!-- =================================================
                 SERVICES
            ================================================== -->

            <div class="col-lg-3 col-md-6">

                <div class="footer-column">

                    <h5>
                        Our Services
                    </h5>

                    <ul class="footer-links">

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                Architectural Design
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                Interior Design
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                Exterior Design
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                Landscape Design
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                Renovation & Remodeling
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                3D Visualization
                            </a>
                        </li>

                        <li>
                            <a href="<?= SITE_URL; ?>/services.php">
                                <i class="bi bi-arrow-right-short"></i>
                                Project Management
                            </a>
                        </li>

                    </ul>

                </div>

            </div>



            <!-- =================================================
                 CONTACT
            ================================================== -->

            <div class="col-lg-3 col-md-6">

                <div class="footer-column">

                    <h5>
                        Contact Us
                    </h5>


                    <!-- Address -->

                    <?php if(!empty($settings['address'])): ?>

                        <div class="footer-contact-item">

                            <span class="footer-contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>

                            <div>
                                <span class="footer-contact-label">
                                    Visit Us
                                </span>

                                <p>
                                    <?= e($settings['address']); ?>
                                </p>
                            </div>

                        </div>

                    <?php endif; ?>



                    <!-- Email -->

                    <?php if(!empty($settings['email'])): ?>

                        <div class="footer-contact-item">

                            <span class="footer-contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </span>

                            <div>

                                <span class="footer-contact-label">
                                    Email Us
                                </span>

                                <a
                                    href="mailto:<?= e($settings['email']); ?>"
                                >
                                    <?= e($settings['email']); ?>
                                </a>

                            </div>

                        </div>

                    <?php endif; ?>



                    <!-- Phone -->

                    <?php if(!empty($settings['phone'])): ?>

                        <div class="footer-contact-item">

                            <span class="footer-contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </span>

                            <div>

                                <span class="footer-contact-label">
                                    Call Us
                                </span>

                                <a
                                    href="tel:<?= e($settings['phone']); ?>"
                                >
                                    <?= e($settings['phone']); ?>
                                </a>

                            </div>

                        </div>

                    <?php endif; ?>



                    <!-- WhatsApp -->

                    <?php if(!empty($settings['whatsapp'])): ?>

                        <div class="footer-contact-item">

                            <span class="footer-contact-icon">
                                <i class="bi bi-whatsapp"></i>
                            </span>

                            <div>

                                <span class="footer-contact-label">
                                    WhatsApp
                                </span>

                                <a
                                    href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <?= e($settings['whatsapp']); ?>
                                </a>

                            </div>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>



        <!-- =====================================================
             FOOTER BOTTOM
        ====================================================== -->

        <div class="footer-bottom">

            <div class="footer-copyright">

                <p class="mb-0">

                    <?= e($settings['footer_text']); ?>

                </p>

            </div>


            <div class="footer-bottom-links">

                <a href="<?= SITE_URL; ?>/privacy-policy.php">
                    Privacy Policy
                </a>

                <span>•</span>

                <a href="<?= SITE_URL; ?>/terms.php">
                    Terms & Conditions
                </a>

            </div>

        </div>

    </div>

</footer>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS -->

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
AOS.init({
    duration:800,
    once:true
});
</script>

<!-- Swiper -->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- GLightbox -->

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
const lightbox = GLightbox();
</script>

<!-- Main JS -->

<script src="<?= asset('js/main.js'); ?>"></script>

</body>
</html>