<?php

require_once 'config/config.php';
require_once 'includes/functions.php';

/*
|--------------------------------------------------------------------------
| Validate Slug
|--------------------------------------------------------------------------
*/

$slug = isset($_GET['slug'])
    ? trim($_GET['slug'])
    : '';

if (empty($slug)) {

    header("Location: " . SITE_URL . "/blog.php");
    exit;

}

/*
|--------------------------------------------------------------------------
| Get Blog Post
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        b.*,
        c.title AS category_title,
        c.slug AS category_slug

    FROM blog b

    LEFT JOIN blog_categories c
        ON b.category_id = c.id

    WHERE
        b.slug = ?
        AND b.status = 'published'

    LIMIT 1
");

$stmt->execute([$slug]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {

    http_response_code(404);

    $pageTitle = "Article Not Found | " . setting('company_name');

    include 'includes/header.php';
    include 'includes/navbar.php';

    ?>

    <section class="os-section os-section-light">

        <div class="container">

            <div
                class="os-blog-empty text-center"
                data-aos="fade-up">

                <div class="os-blog-empty-icon">

                    <i class="bi bi-file-earmark-x"></i>

                </div>

                <h1>
                    Article Not Found
                </h1>

                <p>
                    The article you are looking for does not exist
                    or is no longer published.
                </p>

                <a
                    href="<?= SITE_URL; ?>/blog.php"
                    class="os-btn os-btn-primary">

                    Back to Blog

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        </div>

    </section>

    <?php

    include 'includes/footer.php';

    exit;
}

/*
|--------------------------------------------------------------------------
| Increase Views
|--------------------------------------------------------------------------
*/

$updateViews = $pdo->prepare("
    UPDATE blog
    SET views = views + 1
    WHERE id = ?
");

$updateViews->execute([$post['id']]);

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = !empty($post['meta_title'])
    ? $post['meta_title']
    : $post['title'] . " | " . setting('company_name');

$metaDescription = !empty($post['meta_description'])
    ? $post['meta_description']
    : $post['short_description'];

$metaKeywords = $post['category_title'] ?? '';

/*
|--------------------------------------------------------------------------
| Image
|--------------------------------------------------------------------------
*/

$postImage = !empty($post['thumbnail'])
    ? upload('blog/' . $post['thumbnail'])
    : asset('images/blog-placeholder.jpg');

$postDate = !empty($post['created_at'])
    ? date('F d, Y', strtotime($post['created_at']))
    : '';

/*
|--------------------------------------------------------------------------
| Related Posts
|--------------------------------------------------------------------------
*/

$relatedStmt = $pdo->prepare("
    SELECT
        b.id,
        b.title,
        b.slug,
        b.thumbnail,
        b.short_description,
        b.created_at

    FROM blog b

    WHERE
        b.status = 'published'
        AND b.id != ?
        AND b.category_id = ?

    ORDER BY
        b.created_at DESC

    LIMIT 3
");

$relatedStmt->execute([
    $post['id'],
    $post['category_id']
]);

$relatedPosts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include 'includes/header.php';
include 'includes/navbar.php';

?>

<!-- =========================================================
     BLOG ARTICLE HERO
========================================================= -->

<section class="os-page-hero os-blog-detail-hero">

    <div class="container">

        <div
            class="os-page-hero-content"
            data-aos="fade-up">

            <?php if (!empty($post['category_title'])): ?>

                <span class="os-section-eyebrow">

                    <?= e($post['category_title']); ?>

                </span>

            <?php endif; ?>

            <h1>

                <?= e($post['title']); ?>

            </h1>

            <div class="os-blog-detail-meta">

                <?php if (!empty($post['author'])): ?>

                    <span>

                        <i class="bi bi-person me-1"></i>

                        <?= e($post['author']); ?>

                    </span>

                <?php endif; ?>


                <?php if (!empty($postDate)): ?>

                    <span>

                        <i class="bi bi-calendar3 me-1"></i>

                        <?= e($postDate); ?>

                    </span>

                <?php endif; ?>


                <span>

                    <i class="bi bi-eye me-1"></i>

                    <?= (int) $post['views'] + 1; ?> views

                </span>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     BLOG ARTICLE
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <div class="row g-5">

            <!-- Main Article -->

            <div class="col-lg-8">

                <article
                    class="os-blog-detail"
                    data-aos="fade-up">

                    <!-- Featured Image -->

                    <div class="os-blog-detail-image mb-4">

                        <img
                            src="<?= e($postImage); ?>"
                            alt="<?= e($post['title']); ?>">

                    </div>


                    <!-- Article Content -->

                    <div class="os-blog-detail-content">

                        <?= $post['content']; ?>

                    </div>

                </article>

            </div>


            <!-- Sidebar -->

            <div class="col-lg-4">

                <aside
                    class="os-blog-sidebar"
                    data-aos="fade-up">

                    <!-- About -->

                    <div class="os-blog-sidebar-card">

                        <span class="os-section-eyebrow">
                            OmniSphere Architecture
                        </span>

                        <h3>
                            Architecture. Design. Innovation.
                        </h3>

                        <p>
                            Explore professional architectural,
                            interior, exterior and visualization
                            solutions from concept to completion.
                        </p>

                        <a
                            href="<?= SITE_URL; ?>/contact.php"
                            class="os-btn os-btn-primary">

                            Start Your Project

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>


                    <!-- Category -->

                    <?php if (!empty($post['category_title'])): ?>

                        <div class="os-blog-sidebar-card">

                            <h3>
                                Category
                            </h3>

                            <a
                                href="<?= SITE_URL; ?>/blog.php?category=<?= urlencode($post['category_slug']); ?>">

                                <?= e($post['category_title']); ?>

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    <?php endif; ?>

                </aside>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     RELATED POSTS
========================================================= -->

<?php if (!empty($relatedPosts)): ?>

<section class="os-section os-section-light">

    <div class="container">

        <div
            class="os-section-header"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                Continue Reading
            </span>

            <h2 class="os-section-title">
                Related Articles
            </h2>

        </div>


        <div class="row g-4">

            <?php foreach ($relatedPosts as $related): ?>

                <?php

                $relatedImage = !empty($related['thumbnail'])
                    ? upload('blog/' . $related['thumbnail'])
                    : asset('images/blog-placeholder.jpg');

                ?>

                <div
                    class="col-lg-4 col-md-6"
                    data-aos="fade-up">

                    <article class="os-blog-card">

                        <a
                            href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($related['slug']); ?>"
                            class="os-blog-image">

                            <img
                                src="<?= e($relatedImage); ?>"
                                alt="<?= e($related['title']); ?>"
                                loading="lazy">

                        </a>

                        <div class="os-blog-content">

                            <h3 class="os-blog-title">

                                <a
                                    href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($related['slug']); ?>">

                                    <?= e($related['title']); ?>

                                </a>

                            </h3>

                            <?php if (!empty($related['short_description'])): ?>

                                <p class="os-blog-description">

                                    <?= e($related['short_description']); ?>

                                </p>

                            <?php endif; ?>

                            <a
                                href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($related['slug']); ?>"
                                class="os-blog-read-more">

                                Read Article

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </article>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<?php endif; ?>


<?php include 'includes/footer.php'; ?>