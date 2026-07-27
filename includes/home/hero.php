<section class="hero-section">

    <div class="container">

        <div class="row align-items-center min-vh-100">

            <div class="col-lg-6" data-aos="fade-right">

                <span class="hero-subtitle">

                    Welcome to

                </span>

                <h1 class="hero-title">

                    <?= e(setting('company_name')); ?>

                </h1>

                <p class="hero-tagline">

                    <?= e(setting('tagline')); ?>

                </p>

                <p class="hero-description">

                    We create innovative architecture, stunning interiors,
                    inspiring exteriors, and realistic 3D visualizations that
                    transform ideas into extraordinary spaces.

                </p>

                <div class="hero-buttons">

                    <a
                        href="<?= SITE_URL; ?>/portfolio.php"
                        class="btn btn-primary btn-lg">

                        View Portfolio

                    </a>

                    <a
                        href="<?= SITE_URL; ?>/contact.php"
                        class="btn btn-outline-primary btn-lg">

                        Get Free Consultation

                    </a>

                </div>

            </div>

            <div class="col-lg-6 text-center" data-aos="fade-left">

                <img
                    src="<?= asset('images/hero.png'); ?>"
                    alt="Hero Image"
                    class="img-fluid hero-image">

            </div>

        </div>

    </div>

</section>