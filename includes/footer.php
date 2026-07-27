<?php

$settings = getSettings();

$logo = !empty($settings['logo'])
    ? upload('settings/' . $settings['logo'])
    : asset('images/logo.png');

?>

<!-- ===========================
Footer Start
=========================== -->

<footer class="footer bg-dark text-white pt-5">

    <div class="container">

        <div class="row gy-4">

            <!-- Company -->

            <div class="col-lg-4">

                <img
                    src="<?= $logo; ?>"
                    alt="<?= e($settings['company_name']); ?>"
                    class="footer-logo mb-3">

                <h4>

                    <?= e($settings['company_name']); ?>

                </h4>

                <p>

                    <?= e($settings['tagline']); ?>

                </p>

            </div>

            <!-- Contact -->

            <div class="col-lg-4">

                <h5 class="mb-3">

                    Contact Info

                </h5>

                <p>

                    <i class="bi bi-geo-alt-fill me-2"></i>

                    <?= e($settings['address']); ?>

                </p>

                <p>

                    <i class="bi bi-envelope-fill me-2"></i>

                    <a
                        href="mailto:<?= e($settings['email']); ?>"
                        class="text-white text-decoration-none">

                        <?= e($settings['email']); ?>

                    </a>

                </p>

                <p>

                    <i class="bi bi-telephone-fill me-2"></i>

                    <a
                        href="tel:<?= e($settings['phone']); ?>"
                        class="text-white text-decoration-none">

                        <?= e($settings['phone']); ?>

                    </a>

                </p>

                <p>

                    <i class="bi bi-whatsapp me-2"></i>

                    <a
                        href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp']); ?>"
                        target="_blank"
                        class="text-white text-decoration-none">

                        <?= e($settings['whatsapp']); ?>

                    </a>

                </p>

            </div>

            <!-- Social -->

            <div class="col-lg-4">

                <h5 class="mb-3">

                    Follow Us

                </h5>

                <div class="social-icons">

                    <?php if(!empty($settings['facebook'])): ?>

                    <a
                        href="<?= e($settings['facebook']); ?>"
                        target="_blank">

                        <i class="bi bi-facebook"></i>

                    </a>

                    <?php endif; ?>

                    <?php if(!empty($settings['instagram'])): ?>

                    <a
                        href="<?= e($settings['instagram']); ?>"
                        target="_blank">

                        <i class="bi bi-instagram"></i>

                    </a>

                    <?php endif; ?>

                    <?php if(!empty($settings['linkedin'])): ?>

                    <a
                        href="<?= e($settings['linkedin']); ?>"
                        target="_blank">

                        <i class="bi bi-linkedin"></i>

                    </a>

                    <?php endif; ?>

                    <?php if(!empty($settings['youtube'])): ?>

                    <a
                        href="<?= e($settings['youtube']); ?>"
                        target="_blank">

                        <i class="bi bi-youtube"></i>

                    </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <hr class="border-secondary my-4">

        <div class="text-center">

            <p class="mb-0">

                <?= e($settings['footer_text']); ?>

            </p>

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