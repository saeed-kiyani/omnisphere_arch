<section class="about-section py-5">

    <div class="container">

        <div class="row align-items-center">

            <!-- Image -->

            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">

                <img
                    src="<?= asset('images/about.jpg'); ?>"
                    alt="About <?= e(setting('company_name')); ?>"
                    class="img-fluid rounded shadow">

            </div>

            <!-- Content -->

            <div class="col-lg-6" data-aos="fade-left">

                <span class="section-subtitle">

                    About Us

                </span>

                <h2 class="section-title">

                    <?= e(setting('company_name')); ?>

                </h2>

                <p class="about-text">

                    <?= e(setting('tagline')); ?>

                </p>

                <p class="about-text">

                    At <strong><?= e(setting('company_name')); ?></strong>,
                    we provide complete architectural solutions including
                    Architectural Design, Interior Design, Exterior Design,
                    3D Visualization, Landscape Design, Renovation &
                    Remodeling, and Project Management.

                </p>

                <p class="about-text">

                    Our goal is to transform ideas into functional,
                    sustainable, and visually stunning spaces through
                    creativity, innovation, and attention to detail.

                </p>

                <div class="row mt-4">

                    <div class="col-6 mb-3">

                        <div class="about-counter">

                            <h3>100+</h3>

                            <span>Projects Completed</span>

                        </div>

                    </div>

                    <div class="col-6 mb-3">

                        <div class="about-counter">

                            <h3>50+</h3>

                            <span>Happy Clients</span>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="about-counter">

                            <h3>10+</h3>

                            <span>Expert Designers</span>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="about-counter">

                            <h3>24/7</h3>

                            <span>Client Support</span>

                        </div>

                    </div>

                </div>

                <a
                    href="<?= SITE_URL; ?>/about.php"
                    class="btn btn-primary mt-4">

                    Learn More

                </a>

            </div>

        </div>

    </div>

</section>