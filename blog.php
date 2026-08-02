<?php

require_once 'config/config.php';
require_once 'includes/functions.php';

/*
|--------------------------------------------------------------------------
| Blog Page
|--------------------------------------------------------------------------
*/

$pageTitle = "Blog | " . setting('company_name');

$metaDescription = "Read the latest architecture, interior design, exterior design, renovation and 3D visualization insights from OmniSphere Architecture.";

$metaKeywords = "architecture blog, interior design, exterior design, 3D visualization, renovation, remodeling, OmniSphere Architecture";

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

$postsPerPage = 6;

$currentPage = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;

$offset = ($currentPage - 1) * $postsPerPage;

/*
|--------------------------------------------------------------------------
| Category Filter
|--------------------------------------------------------------------------
*/

$categorySlug = isset($_GET['category'])
    ? trim($_GET['category'])
    : '';

/*
|--------------------------------------------------------------------------
| Get Current Category
|--------------------------------------------------------------------------
*/

$currentCategory = null;

if (!empty($categorySlug)) {

    $categoryStmt = $pdo->prepare("
        SELECT *
        FROM blog_categories
        WHERE slug = ?
        AND status = 'published'
        LIMIT 1
    ");

    $categoryStmt->execute([$categorySlug]);

    $currentCategory = $categoryStmt->fetch(PDO::FETCH_ASSOC);

}

/*
|--------------------------------------------------------------------------
| Count Posts
|--------------------------------------------------------------------------
*/

if ($currentCategory) {

    $countStmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM blog b
        WHERE b.status = 'published'
        AND b.category_id = ?
    ");

    $countStmt->execute([$currentCategory['id']]);

} else {

    $countStmt = $pdo->query("
        SELECT COUNT(*)
        FROM blog
        WHERE status = 'published'
    ");

}

$totalPosts = (int) $countStmt->fetchColumn();

$totalPages = $totalPosts > 0
    ? (int) ceil($totalPosts / $postsPerPage)
    : 1;

/*
|--------------------------------------------------------------------------
| Get Blog Posts
|--------------------------------------------------------------------------
*/

if ($currentCategory) {

    $stmt = $pdo->prepare("
        SELECT
            b.id,
            b.category_id,
            b.title,
            b.slug,
            b.thumbnail,
            b.short_description,
            b.author,
            b.featured,
            b.views,
            b.created_at,
            c.title AS category_title,
            c.slug AS category_slug

        FROM blog b

        LEFT JOIN blog_categories c
            ON b.category_id = c.id

        WHERE
            b.status = 'published'
            AND b.category_id = ?

        ORDER BY
            b.featured DESC,
            b.created_at DESC

        LIMIT $postsPerPage OFFSET $offset
    ");

    $stmt->execute([$currentCategory['id']]);

} else {

    $stmt = $pdo->query("
        SELECT
            b.id,
            b.category_id,
            b.title,
            b.slug,
            b.thumbnail,
            b.short_description,
            b.author,
            b.featured,
            b.views,
            b.created_at,
            c.title AS category_title,
            c.slug AS category_slug

        FROM blog b

        LEFT JOIN blog_categories c
            ON b.category_id = c.id

        WHERE
            b.status = 'published'

        ORDER BY
            b.featured DESC,
            b.created_at DESC

        LIMIT $postsPerPage OFFSET $offset
    ");

}

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

$categoryStmt = $pdo->query("
    SELECT
        id,
        title,
        slug

    FROM blog_categories

    WHERE status = 'published'

    ORDER BY
        display_order ASC,
        title ASC
");

$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include 'includes/header.php';
include 'includes/navbar.php';

?>

<!-- =========================================================
     BLOG HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-page-hero-content"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                OmniSphere Insights
            </span>

            <h1>
                Architecture & Design Blog
            </h1>

            <p>
                Discover architectural ideas, interior design inspiration,
                renovation insights and practical guidance from OmniSphere Architecture.
            </p>

        </div>

    </div>

</section>


<!-- =========================================================
     BLOG CONTENT
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">


        <!-- Category Filter -->

        <?php if (!empty($categories)): ?>

            <div
                class="os-blog-categories mb-5"
                data-aos="fade-up">

                <a
                    href="<?= SITE_URL; ?>/blog.php"
                    class="<?= empty($categorySlug) ? 'active' : ''; ?>">

                    All Posts

                </a>

                <?php foreach ($categories as $category): ?>

                    <a
                        href="<?= SITE_URL; ?>/blog.php?category=<?= urlencode($category['slug']); ?>"
                        class="<?= $categorySlug === $category['slug'] ? 'active' : ''; ?>">

                        <?= e($category['title']); ?>

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- Current Category -->

        <?php if ($currentCategory): ?>

            <div
                class="os-section-header mb-5"
                data-aos="fade-up">

                <span class="os-section-eyebrow">
                    Blog Category
                </span>

                <h2 class="os-section-title">
                    <?= e($currentCategory['title']); ?>
                </h2>

            </div>

        <?php endif; ?>


        <!-- Blog Posts -->

        <?php if (!empty($posts)): ?>

            <div class="row g-4">

                <?php foreach ($posts as $post): ?>

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


                                <h2 class="os-blog-title">

                                    <a
                                        href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($post['slug']); ?>">

                                        <?= e($post['title']); ?>

                                    </a>

                                </h2>


                                <?php if (!empty($post['short_description'])): ?>

                                    <p class="os-blog-description">

                                        <?= e($post['short_description']); ?>

                                    </p>

                                <?php endif; ?>


                                <div class="os-blog-footer">

                                    <?php if (!empty($post['author'])): ?>

                                        <span>

                                            <i class="bi bi-person me-1"></i>

                                            <?= e($post['author']); ?>

                                        </span>

                                    <?php endif; ?>


                                    <a
                                        href="<?= SITE_URL; ?>/blog-details.php?slug=<?= urlencode($post['slug']); ?>"
                                        class="os-blog-read-more">

                                        Read More

                                        <i class="bi bi-arrow-right"></i>

                                    </a>

                                </div>

                            </div>

                        </article>

                    </div>

                <?php endforeach; ?>

            </div>


            <!-- Pagination -->

            <?php if ($totalPages > 1): ?>

                <nav
                    class="os-pagination mt-5"
                    aria-label="Blog pagination">

                    <?php if ($currentPage > 1): ?>

                        <a
                            href="<?= SITE_URL; ?>/blog.php?<?= http_build_query([
                                'category' => $categorySlug,
                                'page' => $currentPage - 1
                            ]); ?>"
                            class="os-pagination-link">

                            <i class="bi bi-arrow-left"></i>

                            Previous

                        </a>

                    <?php endif; ?>


                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                        <a
                            href="<?= SITE_URL; ?>/blog.php?<?= http_build_query([
                                'category' => $categorySlug,
                                'page' => $i
                            ]); ?>"
                            class="os-pagination-link <?= $i === $currentPage ? 'active' : ''; ?>">

                            <?= $i; ?>

                        </a>

                    <?php endfor; ?>


                    <?php if ($currentPage < $totalPages): ?>

                        <a
                            href="<?= SITE_URL; ?>/blog.php?<?= http_build_query([
                                'category' => $categorySlug,
                                'page' => $currentPage + 1
                            ]); ?>"
                            class="os-pagination-link">

                            Next

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    <?php endif; ?>

                </nav>

            <?php endif; ?>


        <?php else: ?>

            <!-- Empty State -->

            <div
                class="os-blog-empty text-center"
                data-aos="fade-up">

                <div class="os-blog-empty-icon">

                    <i class="bi bi-journal-text"></i>

                </div>

                <h2>
                    No Articles Found
                </h2>

                <p>
                    There are currently no published articles in this category.
                </p>

                <a
                    href="<?= SITE_URL; ?>/blog.php"
                    class="os-btn os-btn-primary">

                    View All Posts

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        <?php endif; ?>

    </div>

</section>


<?php include 'includes/footer.php'; ?>