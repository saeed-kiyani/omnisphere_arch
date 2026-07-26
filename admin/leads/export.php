<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/config.php';
require_once '../includes/auth-check.php';

// ===========================
// CSV Headers
// ===========================

$filename = "contact_leads_" . date("Y-m-d_H-i-s") . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');

// ===========================
// Open Output Stream
// ===========================

$output = fopen('php://output', 'w');

// ===========================
// CSV Header Row
// ===========================

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

'Status',

'Notes',

'Created At'

]);

// ===========================
// Fetch Leads
// ===========================

$sql = "

SELECT

contact_leads.*,

services.title AS service_name

FROM contact_leads

LEFT JOIN services

ON contact_leads.service_id = services.id

ORDER BY contact_leads.created_at DESC

";

$stmt = $pdo->query($sql);

// ===========================
// Write CSV Rows
// ===========================

while ($lead = $stmt->fetch(PDO::FETCH_ASSOC)) {

    fputcsv($output, [

        $lead['id'],

        $lead['full_name'],

        $lead['email'],

        $lead['phone'],

        $lead['service_name'],

        $lead['subject'],

        preg_replace("/\r|\n/", " ", $lead['message']),

        $lead['budget'],

        $lead['project_location'],

        $lead['status'],

        preg_replace("/\r|\n/", " ", $lead['notes']),

        $lead['created_at']

    ]);

}

fclose($output);
exit;