<?php

require_once '../config/config.php';
require_once 'includes/auth-check.php';

$pageTitle = "Dashboard Overview";

require_once 'dashboard-data.php';

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/topbar.php';

?>

<div class="content">

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

<!-- Monthly Leads -->

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

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card dashboard-card">

            <div class="card-header">

                <i class="bi bi-journal-text me-2"></i>

                Monthly Blog Posts

            </div>

            <div class="card-body">

                <canvas id="monthlyBlogChart" height="90"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

<div class="col-lg-12">

<div class="card dashboard-card">

<div class="card-header">

<i class="bi bi-graph-up-arrow me-2"></i>

Latest 7-Day Leads Trend

</div>

<div class="card-body">

<canvas id="last7DaysChart" height="90"></canvas>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-lg-6">

<div class="card dashboard-card">

<div class="card-header">

<i class="bi bi-funnel me-2"></i>

Lead Conversion Summary

</div>

<div class="card-body">

<canvas id="leadSummaryChart" height="240"></canvas>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card dashboard-card">

<div class="card-header">

<h5>

<i class="bi bi-funnel me-2"></i>

Sales Pipeline

</h5>

</div>

<div class="card-body">

<?php foreach($leadPipeline as $stage=>$count): ?>

<?php

$percent = round(($count/$totalPipelineLeads)*100);

?>

<div class="pipeline-item">

<div class="d-flex justify-content-between mb-1">

<span class="pipeline-stage">

<?= e($stage) ?>

</span>

<strong>

<?= $count ?>

</strong>

</div>

<div class="progress pipeline-progress">

<div
class="progress-bar"

style="width:<?= $percent ?>%;"

>

<?= $percent ?>%

</div>

</div>

</div>

<?php endforeach; ?>

<hr>

<div class="d-flex justify-content-between">

<strong>Total Leads</strong>

<strong>

<?= array_sum($leadPipeline) ?>

</strong>

</div>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-lg-12">

<div class="card dashboard-card">

<div class="card-header">

<i class="bi bi-bar-chart-line me-2"></i>

Top Requested Services

</div>

<div class="card-body">

<canvas id="serviceAnalyticsChart" height="110"></canvas>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-lg-6">

<div class="card dashboard-card">

<div class="card-header">

<i class="bi bi-share me-2"></i>

Lead Sources

</div>

<div class="card-body">

<canvas id="leadSourcesChart"></canvas>

</div>

</div>

</div>

</div>

<div class="row mt-4">

    <!-- Latest Leads -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-header d-flex justify-content-between">

    <span>
        <i class="bi bi-envelope-paper me-2"></i>
        Latest Leads

    </span>

    <a href="leads/index.php" class="btn btn-outline-secondary text-dark">

        View All

    </a>

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

            <?= timeAgo($lead['created_at']) ?>

        </td>

    </tr>

    <?php endforeach; ?>

<?php else: ?>

<?php endif; ?>

</tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- Recent Blogs -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card">

            <div class="card-header d-flex justify-content-between">

    <span>
        <i class="bi bi-journal-text me-2"></i>
        Recent Blog Posts

    </span>

    <a href="blog/index.php" class="btn btn-outline-secondary text-dark">

        View All

    </a>

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

                <span class="badge bg-warning text-dark">
                    Draft
                </span>

            <?php endif; ?>

        </td>

        <td>
            <?= timeAgo($blog['created_at']) ?>
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

<!-- ========================================================= -->
<!-- Quick Actions -->
<!-- ========================================================= -->

<div class="row mt-4">

    <div class="col-12 mb-3">
        <h4 class="dashboard-section-title">
            Quick Actions
        </h4>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">

        <a href="portfolio/create.php" class="quick-card">

            <div class="quick-icon">
                <i class="bi bi-building"></i>
            </div>

            <h5>Add Portfolio</h5>

            <p>Create new project</p>

        </a>

    </div>

    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">

        <a href="services/create.php" class="quick-card">

            <div class="quick-icon">
                <i class="bi bi-grid"></i>
            </div>

            <h5>Add Service</h5>

            <p>Manage services</p>

        </a>

    </div>

    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">

        <a href="blog/create.php" class="quick-card">

            <div class="quick-icon">
                <i class="bi bi-journal-text"></i>
            </div>

            <h5>Add Blog</h5>

            <p>Write article</p>

        </a>

    </div>

    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">

        <a href="team/create.php" class="quick-card">

            <div class="quick-icon">
                <i class="bi bi-people"></i>
            </div>

            <h5>Add Team</h5>

            <p>Add member</p>

        </a>

    </div>

    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">

        <a href="testimonials/create.php" class="quick-card">

            <div class="quick-icon">
                <i class="bi bi-chat-square-quote"></i>
            </div>

            <h5>Add Testimonial</h5>

            <p>Client reviews</p>

        </a>

    </div>

    <div class="col-lg-2 col-md-4 col-sm-6 mb-4">

        <a href="settings.php" class="quick-card">

            <div class="quick-icon">
                <i class="bi bi-gear"></i>
            </div>

            <h5>Settings</h5>

            <p>Website options</p>

        </a>

    </div>

</div>

<div class="row mt-4">

    <!-- Website Overview -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                <i class="bi bi-globe me-2"></i>

                Website Overview

            </div>

            <div class="card-body">

                <table class="table table-borderless overview-table mb-0">

                    <tr>

                        <td>Status</td>

                        <td>

                            <span class="badge bg-success">

                                <?= $websiteStatus ?>

                            </span>

                        </td>

                    </tr>

                    <tr>

                        <td>Environment</td>

                        <td><?= $environment ?></td>

                    </tr>

                    <tr>

                        <td>PHP Version</td>

                        <td><?= $phpVersion ?></td>

                    </tr>

                    <tr>

                        <td>MySQL</td>

                        <td><?= $mysqlVersion ?></td>

                    </tr>

                    <tr>

                        <td>Server Date</td>

                        <td><?= $serverTime ?></td>

                    </tr>

                    <tr>

                        <td>Server Time</td>

                        <td><?= $serverClock ?></td>

                    </tr>

                </table>

            </div>

        </div>

    </div>



    <!-- Database Overview -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                <i class="bi bi-database me-2"></i>

                Database Overview

            </div>

            <div class="card-body">

                <table class="table table-borderless overview-table mb-0">

                    <tr><td>Portfolio</td><td><?= $portfolioCount ?></td></tr>

                    <tr><td>Services</td><td><?= $serviceCount ?></td></tr>

                    <tr><td>Blogs</td><td><?= $blogCount ?></td></tr>

                    <tr><td>Categories</td><td><?= $categoryCount ?></td></tr>

                    <tr><td>Team</td><td><?= $teamCount ?></td></tr>

                    <tr><td>Testimonials</td><td><?= $testimonialCount ?></td></tr>

                    <tr><td>Leads</td><td><?= $leadCount ?></td></tr>

                    <tr class="fw-bold">

                        <td>Total Records</td>

                        <td><?= $totalRecords ?></td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>



<div class="row">

    <!-- Recent Activity -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                <i class="bi bi-clock-history me-2"></i>

                Recent Activity

            </div>

            <div class="card-body">

                <div class="activity-item">

                    <i class="bi bi-journal-check text-success"></i>

                    <div>

                        <strong>Latest Blog Published</strong>

                        <small><?= count($latestBlogs) ? e($latestBlogs[0]['title']) : "No activity yet." ?></small>

                    </div>

                </div>

                <div class="activity-item">

                    <i class="bi bi-envelope text-primary"></i>

                    <div>

                        <strong>Latest Lead</strong>

                        <small><?= count($latestLeads) ? e($latestLeads[0]['full_name']) : "No leads received." ?></small>

                    </div>

                </div>

                <div class="activity-item">

                    <i class="bi bi-folder2-open text-warning"></i>

                    <div>

                        <strong>Portfolio Projects</strong>

                        <small><?= $portfolioCount ?> Total Projects</small>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- Server Info -->

    <div class="col-lg-6 mb-4">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                <i class="bi bi-cpu me-2"></i>

                Server Information

            </div>

            <div class="card-body">

                <table class="table table-borderless overview-table mb-0">

                    <tr>

                        <td>PHP Version</td>

                        <td><?= $phpVersion ?></td>

                    </tr>

                    <tr>

                        <td>MySQL</td>

                        <td><?= $mysqlVersion ?></td>

                    </tr>

                    <tr>

                        <td>Timezone</td>

                        <td><?= $timezone ?></td>

                    </tr>

                    <tr>

                        <td>Memory Limit</td>

                        <td><?= $memoryLimit ?></td>

                    </tr>

                    <tr>

                        <td>Upload Limit</td>

                        <td><?= $uploadLimit ?></td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

</div>

</div>

        <!-- JAVASCRIPT SCRIPT START -->

<script>

    document.addEventListener("DOMContentLoaded",function(){

document.querySelectorAll(".progress-bar").forEach(bar=>{

const width = bar.style.width;

bar.style.width="0";

setTimeout(()=>{

bar.style.width=width;

},300);

});

});

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

    data: <?= json_encode($monthlyLeads) ?>,

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


const monthlyBlogChart = new Chart(
document.getElementById('monthlyBlogChart'),
{
    type:'line',

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

            label:'Blog Posts',

            data: <?= json_encode($monthlyBlogs) ?>,

            borderColor:'#465F87',

            backgroundColor:'rgba(70,95,135,.12)',

            fill:true,

            tension:.35,

            pointRadius:5,

            pointHoverRadius:7

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

const last7DaysChart = new Chart(

document.getElementById('last7DaysChart'),

{

type:'line',

data:{

labels: <?= json_encode($last7DaysLabels) ?>,

datasets:[{

label:'Leads',

data: <?= json_encode($last7DaysCount) ?>,

borderColor:'#4A8BE2',

backgroundColor:'rgba(74,139,226,.12)',

fill:true,

tension:.4,

pointRadius:5,

pointHoverRadius:7

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

beginAtZero:true,

ticks:{

precision:0

}

}

}

}

});

const leadSummaryChart = new Chart(

document.getElementById('leadSummaryChart'),

{

type:'doughnut',

data:{

labels:[

'New',

'Contacted',

'Quotation Sent',

'Won',

'Lost'

],

datasets:[{

data:[

<?= $leadPipeline['New'] ?>,

<?= $leadPipeline['Contacted'] ?>,

<?= $leadPipeline['Quotation Sent'] ?>,

<?= $leadPipeline['Won'] ?>,

<?= $leadPipeline['Lost'] ?>

],

backgroundColor:[

'#4A8BE2',   // New

'#0dcaf0',   // Contacted

'#ffc107',   // Quotation Sent

'#198754',   // Won

'#dc3545'    // Lost

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

const serviceAnalyticsChart = new Chart(

document.getElementById('serviceAnalyticsChart'),

{

type:'bar',

data:{

labels:<?= json_encode($serviceLabels) ?>,

datasets:[{

label:'Leads',

data:<?= json_encode($serviceTotals) ?>,

backgroundColor:'#4A8BE2',

borderRadius:8

}]

},

options:{

indexAxis:'y',

responsive:true,

plugins:{

legend:{
display:false
}

},

scales:{

x:{
beginAtZero:true
}

}

}

});

const leadSourcesChart = new Chart(

document.getElementById('leadSourcesChart'),

{

type:'doughnut',

data:{

labels:<?= json_encode($sourceLabels) ?>,

datasets:[{

data:<?= json_encode($sourceTotals) ?>,

backgroundColor:[

'#4A8BE2',

'#25D366',

'#1877F2',

'#E4405F',

'#0A66C2',

'#F4B400'

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

        <!-- JAVASCRIPT SCRIPT END -->

<?php

include 'includes/footer.php';

?>