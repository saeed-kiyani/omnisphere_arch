<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/config.php';
require_once '../includes/functions.php';


// =========================================================
// Only POST Requests
// =========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: " . SITE_URL . "/contact.php");

    exit;

}


// =========================================================
// Anti-Spam Honeypot
// =========================================================

if (!empty($_POST['website'])) {

    header("Location: " . SITE_URL . "/contact.php?success=1");

    exit;

}


// =========================================================
// Get Form Data
// =========================================================

$full_name = trim($_POST['full_name'] ?? '');

$email = trim($_POST['email'] ?? '');

$phone = trim($_POST['phone'] ?? '');

$service_id = !empty($_POST['service_id'])
    ? (int) $_POST['service_id']
    : null;

$subject = trim($_POST['subject'] ?? '');

$message = trim($_POST['message'] ?? '');

$budget = trim($_POST['budget'] ?? '');

$project_location = trim($_POST['project_location'] ?? '');

$country = trim($_POST['country'] ?? '');

$city = trim($_POST['city'] ?? '');


// =========================================================
// Validation
// =========================================================

if (
    empty($full_name) ||
    empty($email) ||
    empty($phone) ||
    empty($service_id) ||
    empty($message)
) {

    header(
        "Location: " .
        SITE_URL .
        "/contact.php?error=required"
    );

    exit;

}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header(
        "Location: " .
        SITE_URL .
        "/contact.php?error=email"
    );

    exit;

}


// =========================================================
// Verify Service
// =========================================================

$serviceStmt = $pdo->prepare("
    SELECT id, title
    FROM services
    WHERE id = ?
    AND status = 'Published'
    LIMIT 1
");

$serviceStmt->execute([$service_id]);

$service = $serviceStmt->fetch(PDO::FETCH_ASSOC);


if (!$service) {

    header(
        "Location: " .
        SITE_URL .
        "/contact.php?error=service"
    );

    exit;

}


// =========================================================
// Source
// =========================================================

$source = 'Website';


// =========================================================
// Default Lead Status
// =========================================================

$status = 'New';


// =========================================================
// Insert Lead
// =========================================================

$sql = "
INSERT INTO contact_leads
(
    full_name,
    email,
    phone,
    service_id,
    subject,
    message,
    budget,
    project_location,
    status,
    notes,
    source,
    country,
    city
)
VALUES
(
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    $full_name,
    $email,
    $phone,
    $service_id,
    $subject,
    $message,
    $budget,
    $project_location,
    $status,
    null,
    $source,
    $country,
    $city

]);


// =========================================================
// Lead ID
// =========================================================

$leadId = $pdo->lastInsertId();


// =========================================================
// Email Notification
// =========================================================

$adminEmail = ADMIN_EMAIL;

$emailSubject = "New Website Lead #".$leadId." | OmniSphere Architecture";

$emailBody = "

New Project Inquiry Received

Lead ID: #{$leadId}

----------------------------------------

Name:
{$full_name}

Email:
{$email}

Phone:
{$phone}

Service:
{$service['title']}

Subject:
{$subject}

Budget:
{$budget}

Project Location:
{$project_location}

Country:
{$country}

City:
{$city}

----------------------------------------

Project Details:

{$message}

----------------------------------------

Source:
Website

Status:
New

";


$emailHeaders = [];

$emailHeaders[] = "From: OmniSphere Architecture <" . ADMIN_EMAIL . ">";

$emailHeaders[] = "Reply-To: " . $email;

$emailHeaders[] = "Content-Type: text/plain; charset=UTF-8";


@mail(
    $adminEmail,
    $emailSubject,
    $emailBody,
    implode("\r\n", $emailHeaders)
);


// =========================================================
// Redirect
// =========================================================

header(
    "Location: " .
    SITE_URL .
    "/contact.php?success=1"
);

exit;