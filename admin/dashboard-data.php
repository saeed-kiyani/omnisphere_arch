<?php

/* ===========================
   Dashboard Statistics
=========================== */

$portfolioCount = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();

$serviceCount = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();

$blogCount = $pdo->query("SELECT COUNT(*) FROM blog")->fetchColumn();

$categoryCount = $pdo->query("SELECT COUNT(*) FROM blog_categories")->fetchColumn();

$teamCount = $pdo->query("SELECT COUNT(*) FROM team")->fetchColumn();

$testimonialCount = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();

$leadCount = $pdo->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();

/* Website Status */

$websiteStatus = "Online";
$environment = "Localhost";

$phpVersion = phpversion();

$mysqlVersion = $pdo->query("SELECT VERSION()")->fetchColumn();

$serverTime = date("d M Y");
$serverClock = date("h:i A");

/* Total Database Records */

$totalRecords =
$portfolioCount +
$serviceCount +
$blogCount +
$categoryCount +
$teamCount +
$testimonialCount +
$leadCount;

/* PHP Server Information */

$timezone = date_default_timezone_get();

$memoryLimit = ini_get('memory_limit');

$uploadLimit = ini_get('upload_max_filesize');

// Latest Leads

$latestLeads = $pdo->query("
SELECT
full_name,
email,
created_at
FROM contact_leads
ORDER BY id DESC
LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);


// Latest Blogs

$latestBlogs = $pdo->query("
SELECT
title,
status,
created_at
FROM blog
ORDER BY id DESC
LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);


/* ===========================
   Monthly Leads Analytics
=========================== */

$monthlyLeads = array_fill(0, 12, 0);

$stmt = $pdo->query("
SELECT
MONTH(created_at) AS month,
COUNT(*) AS total
FROM contact_leads
WHERE YEAR(created_at)=YEAR(CURDATE())
GROUP BY MONTH(created_at)
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $monthlyLeads[$row['month']-1] = (int)$row['total'];
}


/* ===========================
   Monthly Blog Analytics
=========================== */

$monthlyBlogs = array_fill(0, 12, 0);

$stmt = $pdo->query("
SELECT
MONTH(created_at) AS month,
COUNT(*) AS total
FROM blog
WHERE YEAR(created_at)=YEAR(CURDATE())
GROUP BY MONTH(created_at)
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $monthlyBlogs[$row['month'] - 1] = (int)$row['total'];
}

/* ===========================
   Last 7 Days Leads
=========================== */

$last7Days = [];
$last7DaysCount = [];

// Initialize last 7 days

for($i = 6; $i >= 0; $i--){

    $date = date('Y-m-d', strtotime("-$i days"));

    $last7Days[$date] = 0;

}

// Get actual data

$stmt = $pdo->query("
SELECT
DATE(created_at) AS lead_date,
COUNT(*) AS total
FROM contact_leads
WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
GROUP BY DATE(created_at)
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    if(isset($last7Days[$row['lead_date']])){

        $last7Days[$row['lead_date']] = (int)$row['total'];

    }

}

$last7DaysLabels = [];
$last7DaysCount = [];

foreach($last7Days as $date => $count){

    $last7DaysLabels[] = date('D', strtotime($date));

    $last7DaysCount[] = $count;

}

/* ===========================
   Lead Pipeline Summary
=========================== */

$leadPipeline = [
    'New' => 0,
    'Contacted' => 0,
    'Quotation Sent' => 0,
    'Won' => 0,
    'Lost' => 0
];

$stmt = $pdo->query("
SELECT status, COUNT(*) total
FROM contact_leads
GROUP BY status
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    $leadPipeline[$row['status']] = (int)$row['total'];

}

$totalPipelineLeads = array_sum($leadPipeline);

if($totalPipelineLeads == 0){
    
    $totalPipelineLeads = 1;
}


/* ==========================================
   Top Requested Services
========================================== */

$serviceAnalytics = $pdo->query("
SELECT
    services.title,
    COUNT(contact_leads.id) AS total
FROM services
LEFT JOIN contact_leads
ON services.id = contact_leads.service_id
GROUP BY services.id
ORDER BY total DESC
")->fetchAll(PDO::FETCH_ASSOC);

$serviceLabels = [];
$serviceTotals = [];

foreach($serviceAnalytics as $row){

    $serviceLabels[] = $row['title'];

    $serviceTotals[] = (int)$row['total'];

}

/* ======================================
   Lead Sources
====================================== */

$leadSources = $pdo->query("
SELECT
source,
COUNT(*) total
FROM contact_leads
GROUP BY source
")->fetchAll(PDO::FETCH_ASSOC);

$sourceLabels = [];
$sourceTotals = [];

foreach($leadSources as $row){

    $sourceLabels[] = $row['source'];

    $sourceTotals[] = (int)$row['total'];

}
