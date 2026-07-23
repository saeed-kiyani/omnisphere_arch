<?php

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Fetch Services
$stmt = $pdo->query("
SELECT id, title
FROM services
WHERE status='Active'
ORDER BY title ASC
");

$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/topbar.php';

?>

<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Add Portfolio Project</h2>

        <a href="index.php" class="btn btn-secondary">
            ← Back
        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <form action="store.php"
                  method="POST"
                  enctype="multipart/form-data">

                <!-- Service -->

                <div class="mb-3">

                    <label class="form-label">
                        Service *
                    </label>

                    <select name="service_id" class="form-control" required>

    <option value="">Select Service</option>

    <?php foreach($services as $service): ?>

        <option value="<?= $service['id']; ?>">
            <?= htmlspecialchars($service['title']); ?>
        </option>

    <?php endforeach; ?>

</select>

                </div>

                <!-- Project Title -->

                <div class="mb-3">

                    <label class="form-label">
                        Project Title *
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

                <!-- Client -->

                <div class="mb-3">

                    <label class="form-label">
                        Client Name
                    </label>

                    <input
                        type="text"
                        name="client_name"
                        class="form-control">

                </div>

                <!-- Location -->

                <div class="mb-3">

                    <label class="form-label">
                        Location
                    </label>

                    <input
                        type="text"
                        name="location"
                        class="form-control">

                </div>

                <!-- Year -->

                <div class="mb-3">

                    <label class="form-label">
                        Project Year
                    </label>

                    <input
                        type="number"
                        name="project_year"
                        min="2000"
                        max="<?= date('Y'); ?>"
                        value="<?= date('Y'); ?>"
                        class="form-control">

                </div>

                <!-- Area -->

                <div class="mb-3">

                    <label class="form-label">
                        Project Area
                    </label>

                    <input
                        type="text"
                        name="project_area"
                        class="form-control"
                        placeholder="Example: 3500 Sq.ft">

                </div>

                <!-- Project Status -->

                <div class="mb-3">

                    <label class="form-label">
                        Project Status
                    </label>

                    <select
                        name="project_status"
                        class="form-select">

                        <option value="Concept">Concept</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed" selected>Completed</option>

                    </select>

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

                        <div class="mt-3">

    <img
    id="thumbnailPreview"
    src=""
    style="display:none;
           max-width:250px;
           border-radius:10px;
           border:1px solid #ddd;
           padding:5px;">

</div>

                </div>

                <!-- Gallery -->

                <div class="mb-3">

                    <label class="form-label">
                        Gallery Images
                    </label>

                    <input
                        type="file"
                        name="gallery[]"
                        class="form-control"
                        multiple
                        accept=".jpg,.jpeg,.png,.webp">

                        <div
id="galleryPreview"
class="row mt-3">

</div>

                    <small class="text-muted">

                        Hold Ctrl to select multiple images.

                    </small>

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
                        Full Description *
                    </label>

                    <textarea
                        name="description"
                        rows="8"
                        class="form-control"
                        required></textarea>

                </div>

                <!-- SEO -->

                <div class="mb-3">

                    <label class="form-label">
                        Meta Title
                    </label>

                    <input
                        type="text"
                        name="meta_title"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Meta Description
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

                        Featured Project

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

                        <option value="Published" selected>
                            Published
                        </option>

                        <option value="Draft">
                            Draft
                        </option>

                    </select>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Save Project

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

const thumbnailInput =
document.querySelector('input[name="thumbnail"]');

const preview =
document.getElementById("thumbnailPreview");

thumbnailInput.addEventListener("change", function(){

    const file = this.files[0];

    if (file.size > 2 * 1024 * 1024) {

    alert("Thumbnail image must be less than 2 MB.");

    this.value = "";

    preview.style.display = "none";

    return;

}

    if(file)
    {
        preview.src = URL.createObjectURL(file);

        preview.style.display = "block";
    }

});

const galleryInput =
document.querySelector('input[name="gallery[]"]');

const galleryPreview =
document.getElementById("galleryPreview");

galleryInput.addEventListener("change", function(){

    if (this.files.length > 20) {

    alert("You can upload a maximum of 20 gallery images.");

    this.value = "";

    galleryPreview.innerHTML = "";

    return;

}

    galleryPreview.innerHTML = "";

    Array.from(this.files).forEach(function(file){

        if (file.size > 2 * 1024 * 1024) {

    alert(file.name + " is larger than 2 MB.");

    return;

}

const allowed = [
    "image/jpeg",
    "image/png",
    "image/webp"
];

if (!allowed.includes(file.type)) {

    alert(file.name + " is not a valid image.");

    return;

}

        const column = document.createElement("div");

        column.className = "col-md-3 mb-3";

        const image = document.createElement("img");

        image.src = URL.createObjectURL(file);

        image.className = "img-fluid rounded border";

        image.style.height = "150px";
        image.style.objectFit = "cover";

        column.appendChild(image);

        galleryPreview.appendChild(column);

    });

});

</script>

<?php include '../includes/footer.php'; ?>