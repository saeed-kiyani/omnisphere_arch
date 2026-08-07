<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/config.php';
require_once '../includes/functions.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
// Email Notification - PHPMailer / Gmail SMTP
// =========================================================

try {

    $mail = new PHPMailer(true);

    // -----------------------------------------------------
    // SMTP Server Settings
    // -----------------------------------------------------

    $mail->isSMTP();

    $mail->Host = SMTP_HOST;

    $mail->SMTPAuth = true;

    $mail->Username = SMTP_USERNAME;

    $mail->Password = SMTP_PASSWORD;

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    $mail->Port = SMTP_PORT;

    // UTF-8
    $mail->CharSet = 'UTF-8';


    // -----------------------------------------------------
    // Sender
    // -----------------------------------------------------

    $mail->setFrom(
        SMTP_FROM_EMAIL,
        SMTP_FROM_NAME
    );


    // -----------------------------------------------------
    // Admin / Business Email
    // -----------------------------------------------------

    $mail->addAddress(
        ADMIN_EMAIL,
        'OmniSphere Architecture'
    );


    // -----------------------------------------------------
    // Reply-To
    // -----------------------------------------------------

    $mail->addReplyTo(
        $email,
        $full_name
    );


    // -----------------------------------------------------
    // Email Subject
    // -----------------------------------------------------

    $mail->Subject =
        "New Website Lead #{$leadId} | OmniSphere Architecture";


    // -----------------------------------------------------
    // HTML Email
    // -----------------------------------------------------

    $mail->isHTML(true);


    $mail->Body = "

<!DOCTYPE html>

<html>

<head>

<meta charset='UTF-8'>

<meta
    name='viewport'
    content='width=device-width, initial-scale=1.0'
>

<meta
    name='x-apple-disable-message-reformatting'
>

<title>New Project Inquiry</title>

</head>


<body style='
    margin:0;
    padding:0;
    width:100%;
    background:#f4f6f1;
    font-family:Arial,Helvetica,sans-serif;
    color:#24301c;
'>


<!-- Outer wrapper -->

<div style='
    width:100%;
    background:#f4f6f1;
    padding:20px 10px;
    box-sizing:border-box;
'>


    <!-- Main card -->

    <div style='
        width:100%;
        max-width:620px;
        margin:0 auto;
        background:#ffffff;
        border:1px solid #e2e7dc;
        border-radius:14px;
        overflow:hidden;
        box-sizing:border-box;
    '>


        <!-- ================================================= -->
        <!-- HEADER -->
        <!-- ================================================= -->

        <div style='
            background:#435522;
            padding:28px 22px;
            text-align:center;
            box-sizing:border-box;
        '>

            <div style='
                font-size:22px;
                line-height:30px;
                font-weight:bold;
                color:#ffffff;
            '>

                New Project Inquiry

            </div>


            <div style='
                margin-top:6px;
                font-size:14px;
                line-height:22px;
                color:#e9eedf;
            '>

                OmniSphere Architecture

            </div>

        </div>


        <!-- ================================================= -->
        <!-- LEAD ID -->
        <!-- ================================================= -->

        <div style='
            padding:22px;
            box-sizing:border-box;
        '>

            <div style='
                background:#f3f6ed;
                border:1px solid #e0e7d5;
                border-radius:10px;
                padding:16px;
                text-align:center;
                box-sizing:border-box;
            '>

                <div style='
                    font-size:12px;
                    line-height:18px;
                    color:#777777;
                    text-transform:uppercase;
                    letter-spacing:1px;
                '>

                    Lead ID

                </div>


                <div style='
                    margin-top:4px;
                    font-size:22px;
                    line-height:30px;
                    font-weight:bold;
                    color:#435522;
                '>

                    #{$leadId}

                </div>

            </div>


            <!-- ================================================= -->
            <!-- INTRO -->
            <!-- ================================================= -->

            <div style='
                margin-top:22px;
                font-size:15px;
                line-height:24px;
                color:#4c5548;
            '>

                A new project inquiry has been submitted
                through the OmniSphere Architecture website.

            </div>


            <!-- ================================================= -->
            <!-- SECTION TITLE -->
            <!-- ================================================= -->

            <div style='
                margin-top:28px;
                margin-bottom:14px;
                font-size:18px;
                line-height:25px;
                font-weight:bold;
                color:#435522;
            '>

                Client Information

            </div>


            <!-- ================================================= -->
            <!-- NAME -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Name

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                    word-break:break-word;
                '>

                    " . e($full_name) . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- EMAIL -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Email

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    overflow-wrap:anywhere;
                    word-break:break-word;
                '>

                    <a
                        href='mailto:" . e($email) . "'
                        style='
                            color:#49668a;
                            text-decoration:none;
                            overflow-wrap:anywhere;
                            word-break:break-word;
                        '
                    >

                        " . e($email) . "

                    </a>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- PHONE -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Phone / WhatsApp

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                '>

                    " . e($phone) . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- SERVICE -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Service

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                    word-break:break-word;
                '>

                    " . e($service['title']) . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- SUBJECT -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Subject

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                    word-break:break-word;
                '>

                    " . e($subject ?: 'Not provided') . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- BUDGET -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Estimated Budget

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                    word-break:break-word;
                '>

                    " . e($budget ?: 'Not provided') . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- PROJECT LOCATION -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Project Location

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                    word-break:break-word;
                '>

                    " . e(
                        $project_location ?: 'Not provided'
                    ) . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- COUNTRY -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    Country

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                '>

                    " . e(
                        $country ?: 'Not detected'
                    ) . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- CITY -->
            <!-- ================================================= -->

            <div style='
                padding:14px 0;
                border-bottom:1px solid #eeeeee;
            '>

                <div style='
                    font-size:11px;
                    line-height:16px;
                    color:#8a927f;
                    text-transform:uppercase;
                    letter-spacing:.7px;
                '>

                    City

                </div>


                <div style='
                    margin-top:4px;
                    font-size:15px;
                    line-height:23px;
                    color:#20271c;
                    overflow-wrap:anywhere;
                '>

                    " . e(
                        $city ?: 'Not detected'
                    ) . "

                </div>

            </div>


            <!-- ================================================= -->
            <!-- PROJECT DETAILS -->
            <!-- ================================================= -->

            <div style='
                margin-top:28px;
                margin-bottom:14px;
                font-size:18px;
                line-height:25px;
                font-weight:bold;
                color:#435522;
            '>

                Project Details

            </div>


            <div style='
                width:100%;
                box-sizing:border-box;
                background:#fafbf8;
                border:1px solid #e1e6dc;
                border-radius:10px;
                padding:18px;
                font-size:15px;
                line-height:25px;
                color:#3e463a;
                overflow-wrap:anywhere;
                word-break:break-word;
            '>

                " . nl2br(e($message)) . "

            </div>


            <!-- ================================================= -->
            <!-- STATUS -->
            <!-- ================================================= -->

            <div style='
                margin-top:25px;
                padding:16px;
                background:#f7f8f5;
                border-radius:10px;
                font-size:13px;
                line-height:23px;
                color:#62695c;
            '>

                <strong>Source:</strong> Website

                <br>

                <strong>Status:</strong> New

            </div>


        </div>


        <!-- ================================================= -->
        <!-- FOOTER -->
        <!-- ================================================= -->

        <div style='
            padding:20px 22px;
            background:#f1f3ed;
            border-top:1px solid #e2e6dd;
            text-align:center;
            box-sizing:border-box;
        '>

            <div style='
                font-size:14px;
                line-height:22px;
                font-weight:bold;
                color:#435522;
            '>

                OmniSphere Architecture

            </div>


            <div style='
                margin-top:3px;
                font-size:12px;
                line-height:20px;
                color:#73796e;
            '>

                Build Ideas Into Reality

            </div>

        </div>


    </div>


</div>


</body>

</html>

";


    // -----------------------------------------------------
    // Plain Text Alternative
    // -----------------------------------------------------

    $mail->AltBody = $emailBody;


    // -----------------------------------------------------
    // Send
    // -----------------------------------------------------

    $mail->send();


} catch (Exception $e) {

    // Email failure should NOT delete the lead.

    error_log(
        'OmniSphere Email Error: ' .
        $e->getMessage()
    );

}

// =========================================================
// Redirect
// =========================================================

header(
    "Location: " .
    SITE_URL .
    "/contact.php?success=1"
);

exit;