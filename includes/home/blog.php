<?php

/*
|--------------------------------------------------------------------------
| Latest Blog Posts
|--------------------------------------------------------------------------
*/

$latestBlogStmt = $pdo->query("
    SELECT
        b.id,
        b.title,
        b.slug,
        b.thumbnail,
        b.short_description,
        b.author,
        b.created_at,
        c.title AS category_title

    FROM blog b

    LEFT JOIN blog_categories c
        ON b.category_id = c.id

    WHERE
        b.status = 'published'

    ORDER BY
        b.featured DESC,
        b.created_at DESC

    LIMIT 3
");

$latestBlogPosts = $latestBlogStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- =========================================================
     LATEST BLOG
========================================================= -->

<section
    class="os-section os-section-light"
    id="latest-blog">

    <div class="container">

        <!-- Section Header -->

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                From Our Blog
            </span>

            <h2 class="os-section-title">
                Latest Insights
            </h2>

            <p class="os-section-description">

                Explore the latest ideas, insights and
                inspiration from OmniSphere Architecture.

            </p>

        </div>


        <?php if (!empty($latestBlogPosts)): ?>

            <div class="row g-4">

                <?php foreach ($latestBlogPosts as $post): ?>

                    <?php

                    $postImage = !empty($post['thumbnail'])
                        ? upload('blog/' . $post['thumbnail'])
                        : asset('images/blog-placeholder.jpg');

                    $postDate = !empty($post['created_at'])
                        ? date('M d, Y', strtotime($post['created_at']))
                        : '';

                    ?>

                    <div
                        class="col-lg-4 col-md-6"
                        data-aos="fade-up">

                        <article class="os-blog-card">

                            <!-- Image -->

                            <a
                                href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($post['slug']); ?>"
                                class="os-blog-image">

                                <img
                                    src="<?= e($postImage); ?>"
                                    alt="<?= e($post['title']); ?>"
                                    loading="lazy">

                            </a>


                            <!-- Content -->

                            <div class="os-blog-content">

                                <div class="os-blog-meta">

                                    <?php if (!empty($post['category_title'])): ?>

                                        <span class="os-blog-category">

                                            <?= e($post['category_title']); ?>

                                        </span>

                                    <?php endif; ?>


                                    <?php if (!empty($postDate)): ?>

                                        <span>

                                            <i class="bi bi-calendar3 me-1"></i>

                                            <?= e($postDate); ?>

                                        </span>

                                    <?php endif; ?>

                                </div>


                                <h3 class="os-blog-title">

                                    <a
                                        href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($post['slug']); ?>">

                                        <?= e($post['title']); ?>

                                    </a>

                                </h3>


                                <?php if (!empty($post['short_description'])): ?>

                                    <p class="os-blog-description">

                                        <?= e($post['short_description']); ?>

                                    </p>

                                <?php endif; ?>


                                <a
                                    href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($post['slug']); ?>"
                                    class="os-blog-read-more">

                                    Read Article

                                    <i class="bi bi-arrow-right"></i>

                                </a>

                            </div>

                        </article>

                    </div>

                <?php endforeach; ?>

            </div>


            <!-- View All -->

            <div
                class="text-center mt-5"
                data-aos="fade-up">

                <a
                    href="<?= SITE_URL; ?>/blog.php"
                    class="os-btn os-btn-primary">

                    View All Articles

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>


        <?php else: ?>

            <div
                class="os-blog-empty text-center"
                data-aos="fade-up">

                <div class="os-blog-empty-icon">

                    <i class="bi bi-journal-text"></i>

                </div>

                <h3>
                    Our Blog Is Coming Soon
                </h3>

                <p>
                    We're preparing helpful architecture
                    and design insights for you.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>