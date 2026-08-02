<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/config.php';
require_once '../includes/functions.php';

/*
|--------------------------------------------------------------------------
| Detect Visitor IP
|--------------------------------------------------------------------------
*/

function getVisitorIP(): ?string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    if (!$ip) {
        return null;
    }

    /*
    Do not trust X-Forwarded-For automatically.
    REMOTE_ADDR is the actual peer connected to PHP.
    */

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        return null;
    }

    return $ip;
}


/*
|--------------------------------------------------------------------------
| Check Whether IP Is Public
|--------------------------------------------------------------------------
*/

function isPublicIP(string $ip): bool
{
    return filter_var(
        $ip,
        FILTER_VALIDATE_IP,
        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
    ) !== false;
}


/*
|--------------------------------------------------------------------------
| Get Location From IP
|--------------------------------------------------------------------------
*/

function getIPLocation(?string $ip): array
{
    if (!$ip || !isPublicIP($ip)) {

        return [
            'country' => null,
            'city' => null
        ];

    }

    $url = "https://ipapi.co/" . rawurlencode($ip) . "/json/";

    $ch = curl_init($url);

    curl_setopt_array($ch, [

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_FOLLOWLOCATION => true,

        CURLOPT_CONNECTTIMEOUT => 2,

        CURLOPT_TIMEOUT => 4,

        CURLOPT_SSL_VERIFYPEER => true,

        CURLOPT_SSL_VERIFYHOST => 2,

        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: OmniSphereArchitecture/1.0'
        ]

    ]);

    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if (
        $response === false ||
        $httpCode < 200 ||
        $httpCode >= 300
    ) {

        return [
            'country' => null,
            'city' => null
        ];

    }

    $data = json_decode($response, true);

    if (!is_array($data)) {

        return [
            'country' => null,
            'city' => null
        ];

    }

    return [

        'country' => !empty($data['country_name'])
            ? trim($data['country_name'])
            : null,

        'city' => !empty($data['city'])
            ? trim($data['city'])
            : null

    ];
}


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

/*
|--------------------------------------------------------------------------
| Automatic IP Location Detection
|--------------------------------------------------------------------------
*/

$visitorIP = getVisitorIP();

$ipLocation = getIPLocation($visitorIP);

$detectedCountry = $ipLocation['country'];
$detectedCity    = $ipLocation['city'];

/*
|--------------------------------------------------------------------------
| Final Client Location
|--------------------------------------------------------------------------
*/

$country = !empty($detectedCountry)
    ? $detectedCountry
    : (!empty($manual_country) ? $manual_country : null);

$city = !empty($detectedCity)
    ? $detectedCity
    : (!empty($manual_city) ? $manual_city : null);


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


$visitorIP = getVisitorIP();

$ipLocation = getIPLocation($visitorIP);

$detectedCountry = $ipLocation['country'];
$detectedCity    = $ipLocation['city'];


$country = !empty($detectedCountry)
    ? $detectedCountry
    : (!empty($_POST['country']) ? trim($_POST['country']) : null);

$city = !empty($detectedCity)
    ? $detectedCity
    : (!empty($_POST['city']) ? trim($_POST['city']) : null);

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