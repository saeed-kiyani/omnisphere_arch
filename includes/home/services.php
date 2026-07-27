<?php

$services = getFeaturedServices();

?>

<section class="services-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <span class="section-subtitle">

                Our Services

            </span>

            <h2 class="section-title">

                Complete Architectural Solutions

            </h2>

            <p class="section-description">

                From concept to completion, we deliver innovative architectural,
                interior, exterior, landscape and visualization services.

            </p>

        </div>

        <div class="row g-4">

            <?php if(count($services) > 0): ?>

                <?php foreach($services as $service): ?>

                <div class="col-lg-4 col-md-6">

                    <div class="service-card h-100" data-aos="fade-up">

                        <img
                            src="<?= imageUrl('services', $service['thumbnail']); ?>"
                            alt="<?= e($service['title']); ?>"
                            class="service-image">

                        <div class="service-content">

                            <h4>

                                <?= e($service['title']); ?>

                            </h4>

                            <p>

                                <?= e(substr(strip_tags($service['short_description']),0,120)); ?>...

                            </p>

                            <a
                                href="<?= SITE_URL; ?>/service-details.php?slug=<?= e($service['slug']); ?>"
                                class="service-link">

                                Read More

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </div>

                </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12 text-center">

                    <p>

                        No featured services found.

                    </p>

                </div>

            <?php endif; ?>

        </div>

        <div class="text-center mt-5">

            <a
                href="<?= SITE_URL; ?>/services.php"
                class="btn btn-primary">

                View All Services

            </a>

        </div>

    </div>

</section>