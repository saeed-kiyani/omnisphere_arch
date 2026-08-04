<?php

/*
|--------------------------------------------------------------------------
| Featured Testimonials
|--------------------------------------------------------------------------
| Homepage shows only published + featured testimonials.
|--------------------------------------------------------------------------
*/

$testimonialStmt = $pdo->query("
    SELECT
        id,
        client_name,
        designation,
        company_name,
        profile_image,
        rating,
        review
    FROM testimonials
    WHERE
        status = 'published'
        AND featured = 1
    ORDER BY
        display_order ASC,
        id DESC
    LIMIT 6
");

$testimonials = $testimonialStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- =========================================================
     TESTIMONIALS
========================================================= -->

<section
    class="os-section os-section-light os-testimonials-section"
    id="testimonials">

    <div class="container">

        <!-- Section Header -->

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                Client Testimonials
            </span>

            <h2 class="os-section-title" style="color: #455123;">
                What Our Clients Say
            </h2>

            <p class="os-section-description" style="color: #08192B;">

                We believe great design is built on trust,
                communication and a commitment to excellence.

            </p>

        </div>


        <?php if (!empty($testimonials)): ?>

            <!-- Testimonials Slider -->

            <div
                class="swiper os-testimonials-slider"
                data-aos="fade-up">

                <div class="swiper-wrapper">

                    <?php foreach ($testimonials as $testimonial): ?>

                        <?php

                        /*
                        |--------------------------------------------------------------------------
                        | Profile Image
                        |--------------------------------------------------------------------------
                        */

                        $testimonialImage = !empty($testimonial['profile_image'])
                            ? upload('testimonials/' . $testimonial['profile_image'])
                            : asset('images/testimonial-placeholder.jpg');


                        /*
                        |--------------------------------------------------------------------------
                        | Rating
                        |--------------------------------------------------------------------------
                        */

                        $rating = (int) $testimonial['rating'];

                        if ($rating < 0) {
                            $rating = 0;
                        }

                        if ($rating > 5) {
                            $rating = 5;
                        }

                        ?>

                        <div class="swiper-slide">

                            <article class="os-testimonial-card">

                                <!-- Rating -->

                                <div class="os-testimonial-rating">

                                    <?php for ($i = 1; $i <= 5; $i++): ?>

                                        <?php if ($i <= $rating): ?>

                                            <i class="bi bi-star-fill"></i>

                                        <?php else: ?>

                                            <i class="bi bi-star"></i>

                                        <?php endif; ?>

                                    <?php endfor; ?>

                                </div>


                                <!-- Review -->

                                <div class="os-testimonial-review">

                                    <i class="bi bi-quote os-testimonial-quote"></i>

                                    <p>

                                        <?= e($testimonial['review']); ?>

                                    </p>

                                </div>


                                <!-- Client -->

                                <div class="os-testimonial-client">

                                    <img
                                        src="<?= e($testimonialImage); ?>"
                                        alt="<?= e($testimonial['client_name']); ?>"
                                        loading="lazy">

                                    <div>

                                        <h3>

                                            <?= e($testimonial['client_name']); ?>

                                        </h3>


                                        <?php if (!empty($testimonial['designation'])): ?>

                                            <span>

                                                <?= e($testimonial['designation']); ?>

                                            </span>

                                        <?php endif; ?>


                                        <?php if (!empty($testimonial['company_name'])): ?>

                                            <small>

                                                <?= e($testimonial['company_name']); ?>

                                            </small>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </article>

                        </div>

                    <?php endforeach; ?>

                </div>


                <!-- Navigation -->

                <div class="swiper-button-prev os-testimonial-prev"></div>

                <div class="swiper-button-next os-testimonial-next"></div>


                <!-- Pagination -->

                <div class="swiper-pagination os-testimonial-pagination"></div>

            </div>


        <?php else: ?>

            <!-- Empty State -->

            <div
                class="os-testimonial-empty"
                data-aos="fade-up">

                <div class="os-testimonial-empty-icon">

                    <i class="bi bi-chat-quote"></i>

                </div>

                <h3>
                    Client Testimonials Coming Soon
                </h3>

                <p>
                    We're currently collecting feedback from
                    our valued clients.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>