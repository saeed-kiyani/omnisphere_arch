<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// Fetch Website Settings
// ===========================

$stmt = $pdo->query("
SELECT *
FROM website_settings
LIMIT 1
");

$settings = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$settings) {

    $_SESSION['error'] = "Website settings record not found.";

    header("Location: ../dashboard.php");
    exit;

}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Website Settings</h2>

</div>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<div class="card shadow">

<div class="card-body">

<form
action="update.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $settings['id']; ?>">

<div class="row">

<!-- ================= Company ================= -->

<div class="col-12">

<h4 class="mb-3">

Company Information

</h4>

<hr>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Company Name

</label>

<input
type="text"
name="company_name"
class="form-control"
value="<?= e($settings['company_name']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Tagline

</label>

<input
type="text"
name="tagline"
class="form-control"
value="<?= e($settings['tagline']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= e($settings['email']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Phone

</label>

<input
type="text"
name="phone"
class="form-control"
value="<?= e($settings['phone']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

WhatsApp

</label>

<input
type="text"
name="whatsapp"
class="form-control"
value="<?= e($settings['whatsapp']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Address

</label>

<input
type="text"
name="address"
class="form-control"
value="<?= e($settings['address']); ?>">

</div>

<!-- ================= Branding ================= -->

<div class="col-12 mt-4">

<h4 class="mb-3">

Branding

</h4>

<hr>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Current Logo

</label>

<br>

<?php if(!empty($settings['logo'])): ?>

<img
src="../../uploads/settings/<?= e($settings['logo']); ?>"
style="max-height:80px;"
class="img-thumbnail mb-2">

<?php else: ?>

<p class="text-muted">No Logo Uploaded</p>

<?php endif; ?>

<input
type="file"
name="logo"
class="form-control"
accept=".jpg,.jpeg,.png,.webp,.svg">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Current Favicon

</label>

<br>

<?php if(!empty($settings['favicon'])): ?>

<img
src="../../uploads/settings/<?= e($settings['favicon']); ?>"
style="width:48px;height:48px;"
class="img-thumbnail mb-2">

<?php else: ?>

<p class="text-muted">No Favicon Uploaded</p>

<?php endif; ?>

<input
type="file"
name="favicon"
class="form-control"
accept=".ico,.png,.jpg,.jpeg,.webp">

</div>

<!-- ================= Google Map ================= -->

<div class="col-12 mt-4">

<h4 class="mb-3">

Google Map

</h4>

<hr>

</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Google Map Iframe

</label>

<textarea
name="google_map_iframe"
rows="4"
class="form-control"><?= e($settings['google_map_iframe']); ?></textarea>

</div>

<!-- ================= Social ================= -->

<div class="col-12 mt-4">

<h4 class="mb-3">

Social Media

</h4>

<hr>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Facebook

</label>

<input
type="url"
name="facebook"
class="form-control"
value="<?= e($settings['facebook']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Instagram

</label>

<input
type="url"
name="instagram"
class="form-control"
value="<?= e($settings['instagram']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

LinkedIn

</label>

<input
type="url"
name="linkedin"
class="form-control"
value="<?= e($settings['linkedin']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

YouTube

</label>

<input
type="url"
name="youtube"
class="form-control"
value="<?= e($settings['youtube']); ?>">

</div>

<!-- ================= SEO ================= -->

<div class="col-12 mt-4">

<h4 class="mb-3">

SEO Settings

</h4>

<hr>

</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Meta Title

</label>

<input
type="text"
name="meta_title"
class="form-control"
value="<?= e($settings['meta_title']); ?>">

</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Meta Description

</label>

<textarea
name="meta_description"
rows="3"
class="form-control"><?= e($settings['meta_description']); ?></textarea>

</div>

<div class="col-md-12 mb-3">

<label class="form-label">

Meta Keywords

</label>

<textarea
name="meta_keywords"
rows="2"
class="form-control"><?= e($settings['meta_keywords']); ?></textarea>

</div>

<!-- ================= Marketing ================= -->

<div class="col-12 mt-4">

<h4 class="mb-3">

Marketing

</h4>

<hr>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Google Analytics ID

</label>

<input
type="text"
name="google_analytics_id"
class="form-control"
value="<?= e($settings['google_analytics_id']); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Meta Pixel ID

</label>

<input
type="text"
name="meta_pixel_id"
class="form-control"
value="<?= e($settings['meta_pixel_id']); ?>">

</div>

<!-- ================= Footer ================= -->

<div class="col-12 mt-4">

<h4 class="mb-3">

Footer

</h4>

<hr>

</div>

<div class="col-md-12 mb-4">

<label class="form-label">

Footer Text

</label>

<textarea
name="footer_text"
rows="3"
class="form-control"><?= e($settings['footer_text']); ?></textarea>

</div>

<div class="col-md-12">

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Settings

</button>

</div>

</div>

</form>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>