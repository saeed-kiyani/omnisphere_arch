<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");
    exit;

}

// ===========================
// Get Form Data
// ===========================

$id = (int)$_POST['id'];

$category_id = (int)$_POST['category_id'];

$title = trim($_POST['title']);

$slug = trim($_POST['slug']);

$short_description = trim($_POST['short_description']);

$content = trim($_POST['content']);

$author = trim($_POST['author']);

$meta_title = trim($_POST['meta_title']);

$meta_description = trim($_POST['meta_description']);

$featured = isset($_POST['featured']) ? 1 : 0;

$status = trim($_POST['status']);


// ===========================
// Validation
// ===========================

if(

empty($category_id) ||

empty($title) ||

    empty($slug) ||

    empty($content)

){

    die("Please fill all required fields.");

}


// ===========================
// Fetch Existing Blog
// ===========================

$stmt = $pdo->prepare("
SELECT *
FROM blog
WHERE id=?
");

$stmt->execute([$id]);

$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$blog){

    die("Blog not found.");

}


// ===========================
// Duplicate Slug Check
// ===========================

$check = $pdo->prepare("
SELECT id
FROM blog
WHERE slug=?
AND id!=?
");

$check->execute([

$slug,

$id

]);

if($check->rowCount()>0){

    die("Slug already exists.");

}


// ===========================
// Thumbnail Upload
// ===========================

$thumbnail = $blog['thumbnail'];

if(!empty($_FILES['thumbnail']['name'])){

    $allowed = ['jpg','jpeg','png','webp'];

    $fileName = $_FILES['thumbnail']['name'];

    $tmpName = $_FILES['thumbnail']['tmp_name'];

    $fileSize = $_FILES['thumbnail']['size'];

    $extension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));

    if(!in_array($extension,$allowed)){

        die("Invalid image format.");

    }

    if($fileSize > 2*1024*1024){

        die("Image must be less than 2MB.");

    }

    // Delete old image

    if(

        !empty($blog['thumbnail']) &&

        file_exists("../../uploads/blog/".$blog['thumbnail'])

    ){

        unlink("../../uploads/blog/".$blog['thumbnail']);

    }

    $thumbnail = time()."_".uniqid().".".$extension;

    move_uploaded_file(

        $tmpName,

        "../../uploads/blog/".$thumbnail

    );

}


// ===========================
// Update Blog
// ===========================

$sql = "

UPDATE blog

SET

category_id=?,

title=?,

slug=?,

thumbnail=?,

short_description=?,

content=?,

meta_title=?,

meta_description=?,

author=?,

featured=?,

status=?

WHERE id=?

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

$category_id,

$title,

$slug,

$thumbnail,

$short_description,

$content,

$meta_title,

$meta_description,

$author,

$featured,

$status,

$id

]);


// ===========================
// Success
// ===========================

$_SESSION['success'] = "Blog updated successfully.";

header("Location: index.php");

exit;