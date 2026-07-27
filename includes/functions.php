<?php

if (!defined('SITE_URL')) {
    exit('Direct access not allowed.');
}

/*
|--------------------------------------------------------------------------
| Website Settings
|--------------------------------------------------------------------------
*/

function getSettings()
{
    global $pdo;

    static $settings = null;

    if ($settings === null) {

        $stmt = $pdo->query("
            SELECT *
            FROM website_settings
            LIMIT 1
        ");

        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    return $settings;
}

/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
*/

function getServices($status = 'Published')
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM services
        WHERE status = ?
        ORDER BY display_order ASC, id DESC
    ");

    $stmt->execute([$status]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedServices()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM services
        WHERE status='Published'
        AND featured=1
        ORDER BY display_order ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getServiceBySlug($slug)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM services
        WHERE slug=?
        AND status='Published'
        LIMIT 1
    ");

    $stmt->execute([$slug]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Portfolio
|--------------------------------------------------------------------------
*/

function getPortfolio()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM portfolio
        WHERE status='Published'
        ORDER BY display_order ASC,id DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedPortfolio()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM portfolio
        WHERE featured=1
        AND status='Published'
        ORDER BY display_order ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProjectBySlug($slug)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM portfolio
        WHERE slug=?
        LIMIT 1
    ");

    $stmt->execute([$slug]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Team
|--------------------------------------------------------------------------
*/

function getTeam()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM team
        WHERE status='Published'
        ORDER BY display_order ASC,id ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Testimonials
|--------------------------------------------------------------------------
*/

function getTestimonials()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM testimonials
        WHERE status='Published'
        ORDER BY display_order ASC,id DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedTestimonials()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM testimonials
        WHERE featured='Yes'
        AND status='Published'
        ORDER BY display_order ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/

function getBlogs($limit = null)
{
    global $pdo;

    $sql = "
        SELECT b.*, c.name AS category_name
        FROM blog b
        LEFT JOIN blog_categories c
        ON b.category_id=c.id
        WHERE b.status='Published'
        ORDER BY b.created_at DESC
    ";

    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getBlogBySlug($slug)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM blog
        WHERE slug=?
        AND status='Published'
        LIMIT 1
    ");

    $stmt->execute([$slug]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

function getBlogCategories()
{
    global $pdo;

    return $pdo->query("
        SELECT *
        FROM blog_categories
        ORDER BY name ASC
    ")->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function asset($path)
{
    return SITE_URL . '/assets/' . ltrim($path, '/');
}

function upload($path)
{
    return SITE_URL . '/uploads/' . ltrim($path, '/');
}

function setting($key)
{
    $settings = getSettings();

    return $settings[$key] ?? '';
}

function isActivePage($pages)
{
    $current = basename($_SERVER['PHP_SELF']);

    if (!is_array($pages)) {
        $pages = [$pages];
    }

    return in_array($current, $pages) ? 'active' : '';
}

function pageTitle($title = '')
{
    $settings = getSettings();

    if (empty($title)) {
        return $settings['company_name'];
    }

    return $title . ' | ' . $settings['company_name'];
}

function imageUrl($folder, $filename, $placeholder = 'images/no-image.png')
{
    if (!empty($filename)) {
        return upload($folder . '/' . $filename);
    }

    return asset($placeholder);
}