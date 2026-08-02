<?php

require_once 'config/config.php';
require_once 'includes/functions.php';

$pageTitle = "Contact Us | " . setting('company_name');

$metaDescription = "Contact OmniSphere Architecture for architectural design, interior design, exterior design, 3D visualization, landscape design, renovation and remodeling services.";

include 'includes/header.php';
include 'includes/navbar.php';


// =========================================================
// Get Published Services
// =========================================================

$serviceStmt = $pdo->query("
    SELECT
        id,
        title
    FROM services
    WHERE status = 'Published'
    ORDER BY title ASC
");

$services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);


// =========================================================
// Success / Error Messages
// =========================================================

$successMessage = '';
$errorMessage = '';

if (isset($_GET['success']) && $_GET['success'] == '1') {

    $successMessage = "Thank you! Your project inquiry has been submitted successfully. Our team will contact you shortly.";

}

if (isset($_GET['error'])) {

    switch ($_GET['error']) {

        case 'required':

            $errorMessage = "Please complete all required fields.";

            break;

        case 'email':

            $errorMessage = "Please enter a valid email address.";

            break;

        case 'service':

            $errorMessage = "Please select a valid service.";

            break;

        default:

            $errorMessage = "Something went wrong. Please try again.";

            break;

    }

}

?>

<?php if (!empty($errorMessage)): ?>

    <div
        class="alert alert-danger mb-5"
        data-aos="fade-up">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        <?= e($errorMessage); ?>

    </div>

<?php endif; ?>

<!-- =========================================================
     CONTACT HERO
========================================================= -->

<section class="os-page-hero">

    <div class="container">

        <div
            class="os-page-hero-content"
            data-aos="fade-up">

            <span class="os-section-eyebrow">
                Get In Touch
            </span>

            <h1>
                Let's Discuss Your Project
            </h1>

            <p>
                Tell us about your project and our team will
                get back to you with the right architectural
                solution.
            </p>

        </div>

    </div>

</section>


<!-- =========================================================
     CONTACT SECTION
========================================================= -->

<section class="os-section os-section-light">

    <div class="container">

        <?php if (!empty($successMessage)): ?>

            <div
                class="alert alert-success mb-5"
                data-aos="fade-up">

                <i class="bi bi-check-circle-fill me-2"></i>

                <?= e($successMessage); ?>

            </div>

        <?php endif; ?>


        <div class="row g-5">


            <!-- =================================================
                 CONTACT INFORMATION
            ================================================== -->

            <div
                class="col-lg-5"
                data-aos="fade-right">

                <div class="os-section-header text-start">

                    <span class="os-section-eyebrow">
                        Contact OmniSphere
                    </span>

                    <h2 class="os-section-title">
                        Let's Create Something Exceptional
                    </h2>

                    <p class="os-section-description">
                        Whether you're planning a new home,
                        commercial project, interior,
                        renovation or complete architectural
                        solution, we'd love to hear from you.
                    </p>

                </div>


                <!-- Address -->

                <div class="os-contact-info-item">

                    <div class="os-contact-icon">

                        <i class="bi bi-geo-alt"></i>

                    </div>

                    <div>

                        <h5>
                            Office
                        </h5>

                        <p>
                            <?= e(setting('address')); ?>
                        </p>

                    </div>

                </div>


                <!-- Phone -->

                <div class="os-contact-info-item">

                    <div class="os-contact-icon">

                        <i class="bi bi-telephone"></i>

                    </div>

                    <div>

                        <h5>
                            Phone
                        </h5>

                        <p>

                            <a
                                href="tel:<?= e(setting('phone')); ?>">

                                <?= e(setting('phone')); ?>

                            </a>

                        </p>

                    </div>

                </div>


                <!-- Email -->

                <div class="os-contact-info-item">

                    <div class="os-contact-icon">

                        <i class="bi bi-envelope"></i>

                    </div>

                    <div>

                        <h5>
                            Email
                        </h5>

                        <p>

                            <a
                                href="mailto:<?= e(setting('email')); ?>">

                                <?= e(setting('email')); ?>

                            </a>

                        </p>

                    </div>

                </div>


                <!-- WhatsApp -->

                <div class="os-contact-info-item">

                    <div class="os-contact-icon">

                        <i class="bi bi-whatsapp"></i>

                    </div>

                    <div>

                        <h5>
                            WhatsApp
                        </h5>

                        <p>

                            <a
                                href="https://wa.me/<?= preg_replace('/[^0-9]/', '', setting('whatsapp')); ?>"
                                target="_blank">

                                <?= e(setting('whatsapp')); ?>

                            </a>

                        </p>

                    </div>

                </div>


                <!-- WhatsApp CTA -->

                <div class="mt-4">

                    <a
                        href="https://wa.me/<?= preg_replace('/[^0-9]/', '', setting('whatsapp')); ?>"
                        target="_blank"
                        class="os-btn os-btn-primary">

                        <i class="bi bi-whatsapp me-2"></i>

                        Chat on WhatsApp

                    </a>

                </div>

            </div>


            <!-- =================================================
                 LEAD FORM
            ================================================== -->

            <div
                class="col-lg-7"
                data-aos="fade-left">

                <div class="os-contact-form-card">

                    <div class="mb-4">

                        <span class="os-section-eyebrow">
                            Project Inquiry
                        </span>

                        <h3>
                            Tell Us About Your Project
                        </h3>

                        <p class="text-muted">
                            Please provide a few details so we
                            can better understand your requirements.
                        </p>

                    </div>


                    <form
                        action="<?= SITE_URL; ?>/contact/store.php"
                        method="POST"
                        novalidate>


                        <!-- =================================================
                             Anti Spam Honeypot
                        ================================================== -->

                        <div
                            style="display:none;">

                            <label>
                                Website
                            </label>

                            <input
                                type="text"
                                name="website"
                                tabindex="-1"
                                autocomplete="off">

                        </div>


                        <div class="row g-3">


                            <!-- Full Name -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Full Name *
                                </label>

                                <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    maxlength="150"
                                    required>

                            </div>


                            <!-- Email -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Email Address *
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    maxlength="150"
                                    required>

                            </div>


                            <!-- Phone -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Phone / WhatsApp *
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    maxlength="50"
                                    required>

                            </div>


                            <!-- Service -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Service Required *
                                </label>

                                <select
                                    name="service_id"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        Select a Service
                                    </option>

                                    <?php foreach ($services as $service): ?>

                                        <option
                                            value="<?= (int) $service['id']; ?>">

                                            <?= e($service['title']); ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- Subject -->

                            <div class="col-md-12">

                                <label class="form-label">
                                    Subject
                                </label>

                                <input
                                    type="text"
                                    name="subject"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="e.g. New Residential House Design">

                            </div>


                            <!-- Budget -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Estimated Budget
                                </label>

                                <select
                                    name="budget"
                                    class="form-select">

                                    <option value="">
                                        Select Budget
                                    </option>

                                    <option value="Under PKR 5 Million">
                                        Start $357.55
                                    </option>

                                    <option value="PKR 5 - 10 Million">
                                        $361.16 - $902.90
                                    </option>

                                    <option value="PKR 10 - 25 Million">
                                        $902.90 - $2,528.13
                                    </option>

                                    <option value="PKR 25 - 50 Million">
                                        $2,528.13 - $5,417.42
                                    </option>

                                    <option value="PKR 50 Million+">
                                        $9,029.04
                                    </option>

                                    <option value="Not Decided Yet">
                                        Not Decided Yet
                                    </option>

                                </select>

                            </div>


                            <!-- Project Location -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Project Location
                                </label>

                                <input
                                    type="text"
                                    name="project_location"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="City / Area / Country">

                            </div>


                            <!-- Country -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    Country
                                </label>

                                <input
                                    type="text"
                                    name="country"
                                    class="form-control"
                                    maxlength="100"
                                    placeholder="e.g. Pakistan">

                            </div>


                            <!-- City -->

                            <div class="col-md-6">

                                <label class="form-label">
                                    City
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    class="form-control"
                                    maxlength="100"
                                    placeholder="e.g. Karachi">

                            </div>


                            <!-- Message -->

                            <div class="col-md-12">

                                <label class="form-label">
                                    Project Details *
                                </label>

                                <textarea
                                    name="message"
                                    rows="6"
                                    class="form-control"
                                    maxlength="5000"
                                    placeholder="Tell us about your project, requirements, size, style or any other details..."
                                    required></textarea>

                            </div>


                            <!-- Submit -->

                            <div class="col-md-12 mt-3">

                                <button
                                    type="submit"
                                    class="os-btn os-btn-primary">

                                    <i class="bi bi-send me-2"></i>

                                    Submit Project Inquiry

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     GOOGLE MAP
========================================================= -->

<?php

$googleMap = setting('google_map');

?>

<?php if (!empty($googleMap)): ?>

<section class="os-section os-section-light pt-0">

    <div class="container">

        <div
            class="os-map-wrapper"
            data-aos="fade-up">

            <?= $googleMap; ?>

        </div>

    </div>

</section>

<?php endif; ?>


<?php include 'includes/footer.php'; ?>