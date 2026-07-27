<?php

// Prevent direct access
if (!defined('SITE_URL')) {
    exit('Direct access not allowed.');
}

// Website Settings
$settings = getSettings();

// SEO Defaults
$pageTitle = $pageTitle ?? pageTitle();

$metaDescription = $metaDescription ?? $settings['meta_description'];

$metaKeywords = $metaKeywords ?? $settings['meta_keywords'];

// Logo & Favicon
$logo = !empty($settings['logo'])
    ? upload('settings/' . $settings['logo'])
    : asset('images/logo.png');

$favicon = !empty($settings['favicon'])
    ? upload('settings/' . $settings['favicon'])
    : asset('images/favicon.ico');

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= e($pageTitle); ?></title>

<meta
name="description"
content="<?= e($metaDescription); ?>">

<meta
name="keywords"
content="<?= e($metaKeywords); ?>">

<meta
name="author"
content="<?= e($settings['company_name']); ?>">

<meta
name="robots"
content="index, follow">

<link
rel="icon"
type="image/x-icon"
href="<?= $favicon; ?>">

<!-- Google Fonts -->

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<!-- Bootstrap -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
rel="stylesheet">

<!-- Bootstrap Icons -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
rel="stylesheet">

<!-- Font Awesome -->

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<!-- AOS Animation -->

<link
rel="stylesheet"
href="https://unpkg.com/aos@2.3.4/dist/aos.css">

<!-- Swiper Slider -->

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- GLightbox -->

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

<!-- Main CSS -->

<link
rel="stylesheet"
href="<?= asset('css/style.css'); ?>">

<?php if (!empty($settings['google_analytics_id'])): ?>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e($settings['google_analytics_id']); ?>"></script>

<script>
window.dataLayer = window.dataLayer || [];

function gtag(){
    dataLayer.push(arguments);
}

gtag('js', new Date());

gtag('config', '<?= e($settings['google_analytics_id']); ?>');
</script>

<?php endif; ?>

<?php if (!empty($settings['meta_pixel_id'])): ?>

<!-- Meta Pixel Placeholder -->

<?php endif; ?>

</head>

<body>