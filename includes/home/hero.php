<section class="hero-section">

    <!-- Full Hero Background Video -->
    <div class="hero-video-wrapper">

        <video
            class="hero-video"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
            poster="<?= asset('images/hero.png'); ?>"
        >
            <source
                src="<?= asset('videos/architectural-construction.mp4'); ?>"
                type="video/mp4"
            >

            Your browser does not support the video tag.
        </video>

    </div>

    <!-- Dark / Soft Overlay -->
    <div class="hero-overlay"></div>


    <!-- Hero Content -->
    <div class="container hero-content">

        <div class="row align-items-center">

            <div class="col-lg-8" data-aos="fade-right">

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
                    inspiring exteriors, and realistic 3D visualizations
                    that transform ideas into extraordinary spaces.
                </p>

                <div class="hero-buttons">

                    <a
                        href="<?= SITE_URL; ?>/portfolio.php"
                        class="btn btn-primary btn-lg"
                    >
                        View Portfolio
                    </a>

                    <a
                        href="<?= SITE_URL; ?>/contact.php"
                        class="btn btn-outline-light btn-lg"
                    >
                        Get Free Consultation
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>