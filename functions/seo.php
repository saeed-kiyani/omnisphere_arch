<?php

/*
|--------------------------------------------------------------------------
| SEO Helper Functions
|--------------------------------------------------------------------------
| Global SEO functions for OmniSphere Architecture.
|--------------------------------------------------------------------------
*/


/**
 * Generate the page title.
 *
 * Usage:
 * seo_title('About Us');
 *
 * Output:
 * About Us | OmniSphere Architecture
 */
function seo_title(string $pageTitle = ''): string
{
    if ($pageTitle === '') {
        return SITE_NAME;
    }

    return htmlspecialchars(
        $pageTitle . ' | ' . SITE_NAME,
        ENT_QUOTES,
        'UTF-8'
    );
}


/**
 * Generate a safe meta description.
 */
function seo_description(string $description = ''): string
{
    if ($description === '') {
        $description = SITE_DESCRIPTION;
    }

    return htmlspecialchars(
        $description,
        ENT_QUOTES,
        'UTF-8'
    );
}


/**
 * Generate canonical URL.
 *
 * Usage:
 * seo_canonical('/about.php');
 */
function seo_canonical(string $path = ''): string
{
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}


/**
 * Generate Open Graph image URL.
 */
function seo_image(string $image = ''): string
{
    if ($image === '') {
        return rtrim(SITE_URL, '/') . '/assets/images/og-image.jpg';
    }

    return rtrim(SITE_URL, '/') . '/' . ltrim($image, '/');
}