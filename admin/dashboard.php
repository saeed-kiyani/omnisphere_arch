<?php

require_once '../config/config.php';
require_once 'includes/auth-check.php';

$pageTitle = "Dashboard Overview";

// ================================
// Dashboard Statistics
// ================================

$totalPortfolio = $pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn();

$totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();

$totalBlogs = $pdo->query("SELECT COUNT(*) FROM blog")->fetchColumn();

$totalCategories = $pdo->query("SELECT COUNT(*) FROM blog_categories")->fetchColumn();

$totalTeam = $pdo->query("SELECT COUNT(*) FROM team")->fetchColumn();

$totalTestimonials = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();

$totalLeads = $pdo->query("SELECT COUNT(*) FROM contact_leads")->fetchColumn();

$totalViews = $pdo->query("SELECT IFNULL(SUM(views),0) FROM blog")->fetchColumn();

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

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/topbar.php';

?>

<div class="content">

<p class="text-muted mb-4 text-center">

    Welcome back! Here's what's happening across OmniSphere Architecture today.

</p>

<!-- ===========================
Primary KPI Cards
=========================== -->

<div class="row g-4 mb-4">

<div class="col-lg-3 col-md-6">

<a href="portfolio/index.php" class="text-decoration-none">

<div class="stat-card">

<div class="stat-icon">
    
<i class="bi bi-building"></i>
</div>

<h2><?= $portfolioCount ?? 0; ?></h2>

<h6>Portfolio</h6>

<small>Total Projects</small>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="services/index.php" class="text-decoration-none">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-grid-3x3-gap"></i>
</div>

<h2><?= $serviceCount ?? 0; ?></h2>

<h6>Services</h6>

<small>Total Services</small>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="blog/index.php" class="text-decoration-none">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-journal-richtext"></i>
</div>

<h2><?= $blogCount ?? 0; ?></h2>

<h6>Blog Posts</h6>

<small>Total Articles</small>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="leads/index.php" class="text-decoration-none">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-envelope-paper"></i>
</div>

<h2><?= $leadCount ?? 0; ?></h2>

<h6>Leads</h6>

<small>Total Inquiries</small>

</div>

</a>

</div>

</div>

<!-- ===========================
Secondary KPI Cards
=========================== -->

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<a href="blog-categories/index.php" class="text-decoration-none">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-tags"></i>
</div>

<h2><?= $categoryCount ?? 0; ?></h2>

<h6>Categories</h6>

<small>Blog Categories</small>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="team/index.php" class="text-decoration-none">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-people"></i>
</div>

<h2><?= $teamCount ?? 0; ?></h2>

<h6>Team</h6>

<small>Members</small>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="testimonials/index.php" class="text-decoration-none">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-chat-square-quote"></i>
</div>

<h2><?= $testimonialCount ?? 0; ?></h2>

<h6>Testimonials</h6>

<small>Client Reviews</small>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="blog/index.php" class="text-decoration-none">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-eye"></i>
</div>

<h2><?= $blogViews ?? 0; ?></h2>

<h6>Blog Views</h6>

<small>Total Views</small>

</div>

</a>

</div>

</div>

</div>


<div class="row mt-4">

    <div class="col-lg-8 mb-4">

        <div class="card dashboard-card">

            <div class="card-header">
                Monthly Leads
            </div>

            <div class="card-body">

                <canvas id="monthlyLeadsChart" height="100"></canvas>

                <div class="chart-empty text-center py-5">

    <i class="bi bi-bar-chart-line fs-1 text-secondary"></i>

    <p class="mt-3 mb-0">

        No analytics data available yet.

    </p>

    <small class="text-muted">

        Charts will appear automatically once data is available.

    </small>

</div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 mb-4">

        <div class="card dashboard-card">

            <div class="card-header">
                Website Content Distribution
            </div>

            <div class="card-body">

                <canvas id="contentChart"></canvas>

                <div class="chart-empty text-center py-5">

    <i class="bi bi-bar-chart-line fs-1 text-secondary"></i>

    <p class="mt-3 mb-0">

        No analytics data available yet.

    </p>

    <small class="text-muted">

        Charts will appear automatically once data is available.

    </small>

</div>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <!-- Latest Leads -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-header">

                <i class="bi bi-envelope-paper me-2"></i>

                Latest Leads

            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(count($latestLeads)): ?>

                        <?php foreach($latestLeads as $lead): ?>

                        <tr>

                            <td><?= e($lead['full_name']) ?></td>

                            <td><?= e($lead['email']) ?></td>

                            <td>

                                <?= date('d M Y',strtotime($lead['created_at'])) ?>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="3" class="text-center py-4">

                                No leads yet.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- Recent Blogs -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-header">

                <i class="bi bi-journal-text me-2"></i>

                Recent Blog Posts

            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>

                            <th>Title</th>

                            <th>Status</th>

                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(count($latestBlogs)): ?>

                        <?php foreach($latestBlogs as $blog): ?>

                        <tr>

                            <td>

                                <?= e($blog['title']) ?>

                            </td>

                            <td>

                                <?php if($blog['status']=="Published"): ?>

                                    <span class="badge bg-success">

                                        Published

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-secondary">

                                        Draft

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= date('d M Y',strtotime($blog['created_at'])) ?>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="3" class="text-center py-4">

                                No blog posts.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>

const monthlyLeadChart = new Chart(
document.getElementById('monthlyLeadsChart'),
{
    type:'bar',

    data:{

        labels:[
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],

        datasets:[{

            label:'Leads',

            data:[
                0,0,0,0,0,0,0,0,0,0,0,0
            ],

            backgroundColor:'#4A8BE2',

            borderRadius:8

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{
                display:false
            }

        },

        scales:{

            y:{
                beginAtZero:true
            }

        }

    }

});



const contentChart = new Chart(

document.getElementById('contentChart'),

{

type:'doughnut',

data:{

labels:[

'Portfolio',

'Services',

'Blogs',

'Testimonials'

],

datasets:[{

data:[

<?= $portfolioCount ?>,

<?= $serviceCount ?>,

<?= $blogCount ?>,

<?= $testimonialCount ?>

],

backgroundColor:[

'#4A8BE2',

'#465F87',

'#6C8ECF',

'#C4A574'

],

borderWidth:0

}]

},

options:{

responsive:true,

plugins:{

legend:{

position:'bottom'

}

}

}

});

if(totalLeads > 0){

    document.querySelector('.chart-empty').style.display='none';

    // Initialize Chart.js

}

</script>

<?php

include 'includes/footer.php';

?>