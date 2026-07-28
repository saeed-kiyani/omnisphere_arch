<?php

require_once '../config/config.php';
require_once 'includes/auth-check.php';

$pageTitle = "Dashboard";

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

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/topbar.php';

?>

<div class="content">

<h1 class="dashboard-title mb-4">
Dashboard
</h1>

<!-- ===========================
Primary KPI Cards
=========================== -->

<div class="row g-4 mb-4">

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-building"></i>
</div>

<h2><?= $portfolioCount ?? 0; ?></h2>

<h6>Portfolio</h6>

<small>Total Projects</small>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-grid-3x3-gap"></i>
</div>

<h2><?= $serviceCount ?? 0; ?></h2>

<h6>Services</h6>

<small>Total Services</small>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-journal-richtext"></i>
</div>

<h2><?= $blogCount ?? 0; ?></h2>

<h6>Blog Posts</h6>

<small>Total Articles</small>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<div class="stat-icon">
<i class="bi bi-envelope-paper"></i>
</div>

<h2><?= $leadCount ?? 0; ?></h2>

<h6>Leads</h6>

<small>Total Inquiries</small>

</div>

</div>

</div>

<!-- ===========================
Secondary KPI Cards
=========================== -->

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-tags"></i>
</div>

<h2><?= $categoryCount ?? 0; ?></h2>

<h6>Categories</h6>

<small>Blog Categories</small>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-people"></i>
</div>

<h2><?= $teamCount ?? 0; ?></h2>

<h6>Team</h6>

<small>Members</small>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-chat-square-quote"></i>
</div>

<h2><?= $testimonialCount ?? 0; ?></h2>

<h6>Testimonials</h6>

<small>Client Reviews</small>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card secondary-card">

<div class="stat-icon">
<i class="bi bi-eye"></i>
</div>

<h2><?= $blogViews ?? 0; ?></h2>

<h6>Blog Views</h6>

<small>Total Views</small>

</div>

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

</script>

<?php

include 'includes/footer.php';

?>