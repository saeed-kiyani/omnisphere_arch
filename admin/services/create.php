<?php
require_once '../../config/config.php';
require_once '../includes/auth-check.php';

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';
?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Service</h2>

        <a href="index.php" class="btn btn-secondary">
            ← Back to Services
        </a>
    </div>

    <div class="card shadow">

        <div class="card-body">

            <form action="store.php"
                  method="POST"
                  enctype="multipart/form-data">

                <!-- Service Title -->

                <div class="mb-3">

                    <label class="form-label">
                        Service Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        required>

                </div>

                <!-- Slug -->

                <div class="mb-3">

                    <label class="form-label">
                        Slug
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        class="form-control"
                        readonly>

                </div>

                <!-- Icon -->

                <div class="mb-3">

                    <label class="form-label">
                        Icon
                    </label>

                    <input
                        type="text"
                        name="icon"
                        class="form-control"
                        placeholder="Example: fa-solid fa-house">

                    <small class="text-muted">
                        Font Awesome icon class
                    </small>

                </div>

                <!-- Thumbnail -->

                <div class="mb-3">

                    <label class="form-label">
                        Thumbnail Image
                    </label>

                    <input
                        type="file"
                        name="thumbnail"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp">

                </div>

                <!-- Short Description -->

                <div class="mb-3">

                    <label class="form-label">
                        Short Description
                    </label>

                    <textarea
                        name="short_description"
                        rows="3"
                        class="form-control"></textarea>

                </div>

                <!-- Description -->

                <div class="mb-3">

                    <label class="form-label">
                        Full Description
                    </label>

                    <textarea
                        name="description"
                        rows="8"
                        class="form-control"
                        required></textarea>

                </div>

                <!-- SEO Title -->

                <div class="mb-3">

                    <label class="form-label">
                        SEO Title
                    </label>

                    <input
                        type="text"
                        name="meta_title"
                        class="form-control">

                </div>

                <!-- SEO Description -->

                <div class="mb-3">

                    <label class="form-label">
                        SEO Description
                    </label>

                    <textarea
                        name="meta_description"
                        rows="4"
                        class="form-control"></textarea>

                </div>

                <!-- Featured -->

                <div class="form-check mb-3">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="featured"
                        value="1"
                        id="featured">

                    <label
                        class="form-check-label"
                        for="featured">

                        Featured Service

                    </label>

                </div>

                <!-- Status -->

                <div class="mb-4">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="Published">
                            Published
                        </option>

                        <option value="Draft">
                            Draft
                        </option>

                    </select>

                </div>

                <!-- Buttons -->

                <button
                    type="submit"
                    class="btn btn-primary">

                    Save Service

                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

<script>

// Auto Slug Generator

document
.getElementById('title')
.addEventListener('keyup', function(){

    let slug = this.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g,'-')
        .replace(/^-+|-+$/g,'');

    document.getElementById('slug').value = slug;

});

</script>

<?php include '../includes/footer.php'; ?>