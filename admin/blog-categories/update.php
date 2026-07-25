<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

if($_SERVER['REQUEST_METHOD']!='POST'){

    header("Location:index.php");
    exit;

}

$id=(int)$_POST['id'];

$title=trim($_POST['title']);

$slug=trim($_POST['slug']);

$meta_title=trim($_POST['meta_title']);

$meta_description=trim($_POST['meta_description']);

$display_order=(int)$_POST['display_order'];

$status=trim($_POST['status']);

if(empty($title) || empty($slug)){

    die("Please fill all required fields.");

}

$check=$pdo->prepare("
SELECT id
FROM blog_categories
WHERE slug=?
AND id!=?
");

$check->execute([$slug,$id]);

if($check->rowCount()>0){

    die("Slug already exists.");

}

$stmt=$pdo->prepare("
UPDATE blog_categories
SET
title=?,
slug=?,
meta_title=?,
meta_description=?,
display_order=?,
status=?
WHERE id=?
");

$stmt->execute([

$title,

$slug,

$meta_title,

$meta_description,

$display_order,

$status,

$id

]);

$_SESSION['success']="Category updated successfully.";

header("Location:index.php");

exit;