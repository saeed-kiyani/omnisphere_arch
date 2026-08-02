<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';


// =========================================================
// CSV File Name
// =========================================================

$filename = "contact_leads_" . date("Y-m-d_H-i-s") . ".xlsx";


// =========================================================
// CSV Headers
// =========================================================

header('Content-Type: text/csv; charset=utf-8');

header(
    'Content-Disposition: attachment; filename="' . $filename . '"'
);

header('Pragma: no-cache');

header('Expires: 0');


// =========================================================
// Open Output Stream
// =========================================================

$output = fopen('php://output', 'w');


// =========================================================
// CSV Header Row
// =========================================================

fputcsv($output, [

    'ID',

    'Full Name',

    'Email',

    'Phone',

    'Service',

    'Subject',

    'Message',

    'Budget',

    'Project Location',

    'City',

    'Country',

    'Source',

    'Status',

    'Notes',

    'Created At',

    'Updated At'

]);


// =========================================================
// Fetch Leads
// =========================================================

$sql = "

    SELECT

        contact_leads.*,

        services.title AS service_name

    FROM contact_leads

    LEFT JOIN services

        ON contact_leads.service_id = services.id

    ORDER BY

        contact_leads.created_at DESC

";


$stmt = $pdo->query($sql);


// =========================================================
// Write CSV Rows
// =========================================================

while ($lead = $stmt->fetch(PDO::FETCH_ASSOC)) {

    fputcsv($output, [

        // ID
        $lead['id'],

        // Client
        $lead['full_name'],

        // Email
        $lead['email'],

        // Phone
        $lead['phone'],

        // Service
        $lead['service_name'] ?? '',

        // Subject
        $lead['subject'] ?? '',

        // Message
        preg_replace(
            "/\r|\n/",
            " ",
            $lead['message'] ?? ''
        ),

        // Budget
        $lead['budget'] ?? '',

        // Project Location
        $lead['project_location'] ?? '',

        // City
        $lead['city'] ?? '',

        // Country
        $lead['country'] ?? '',

        // Source
        $lead['source'] ?? '',

        // Status
        $lead['status'] ?? '',

        // Internal Notes
        preg_replace(
            "/\r|\n/",
            " ",
            $lead['notes'] ?? ''
        ),

        // Created
        $lead['created_at'] ?? '',

        // Updated
        $lead['updated_at'] ?? ''

    ]);

}


// =========================================================
// Close Stream
// =========================================================

fclose($output);

exit;