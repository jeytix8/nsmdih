<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('connect.php');

// Fetch Job Orders Per section
$jobOrderPerDept = [];
$query = "SELECT section, COUNT(*) as count FROM records_job_order GROUP BY section ORDER BY section ASC";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $jobOrderPerDept[$row['section']] = $row['count'];
}

// Fetch Job Orders by Type (job_order_nature)
$jobOrderByType = [];
$query = "SELECT job_order_nature, COUNT(*) as count FROM records_job_order GROUP BY job_order_nature ORDER BY job_order_nature ASC";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $jobOrderByType[$row['job_order_nature']] = $row['count'];
}

// Fetch Satisfaction Survey Data
$satisfactionSurvey = [];
$query = "SELECT section, SUM(satisfied) / COUNT(*) AS avg_satisfaction FROM records_job_order GROUP BY section";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    $satisfactionSurvey[$row['section']] = round($row['avg_satisfaction'], 2);
}

// JSON Encode Data for JavaScript
$jobOrderPerDeptJSON = json_encode($jobOrderPerDept);
$jobOrderByTypeJSON = json_encode($jobOrderByType);
$satisfactionSurveyJSON = json_encode($satisfactionSurvey);
?>

<style>
/* Chart Wrapper */
#chart-wrapper {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

/* Each Chart Box */
.chart-box {
    width: 30%;
    min-width: 390px;
    max-width: 400px;
    height: 350px;
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 0 1px; /* 🔹 Adds spacing on both left and right */
}


/* Canvas must be constrained */
.chart-box canvas {
    width: 100% !important;
    height: 250px !important; /* Set a max height */
    max-height: 300px; /* Prevent infinite stretch */
}

/* Responsive Fix */
@media (max-width: 768px) {
    .chart-box {
        width: 90%;
        max-width: 100%;
    }
}
</style>

<!-- Chart Containers -->
<div id="chart-wrapper">
    <div class="chart-box">
        <h3>Job Orders Per Section</h3>
        <canvas id="jobOrderPerSectionChart"></canvas>
    </div>

    <div class="chart-box">
        <h3>Type of Request</h3>
        <canvas id="jobOrderTypeChart"></canvas>
    </div>

    <div class="chart-box">
        <h3>Average Satisfaction (%)</h3>
        <canvas id="satisfactionSurveyChart"></canvas>
    </div>
</div>

<script src="assets/chart/chart.js"></script>
<script src="assets/chart/chartjs-plugin-datalabels.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    Chart.register(ChartDataLabels);

    // Convert PHP JSON data to JavaScript Objects
    const jobOrderPerDept = <?php echo json_encode($jobOrderPerDept); ?>;
    const jobOrderByType = <?php echo json_encode($jobOrderByType); ?>;
    const satisfactionSurvey = <?php echo json_encode($satisfactionSurvey); ?>;

    function createBarChart(canvasId, chartTitle, chartData) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(chartData),
                datasets: [{
                    label: chartTitle,
                    data: Object.values(chartData),
                    backgroundColor: ['#4F81BD', '#76B7B2', '#4C9F70', '#CCCCFF', '#F1916D', '#19305C', '#AE7DAC', '#C48CB3'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Important to prevent infinite stretch
                plugins: {
                    legend: {
                        display: false, 
                    },
                    datalabels: {
                        display: true,
                        color: 'black',
                        font: { weight: 'bold', size: 12 },
                        anchor: 'left',
                        align: 'left'
                    }
                },
                scales: {
                    x: { beginAtZero: true, grid: { color: 'black' }, ticks: { color: 'black' } },
                    y: { grid: { color: 'black' }, ticks: { color: 'black' } }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Initialize Charts
    createBarChart("jobOrderPerSectionChart", "Job Orders Per Section", jobOrderPerDept);
    createBarChart("jobOrderTypeChart", "Type of Request", jobOrderByType);
    createBarChart("satisfactionSurveyChart", "Average Satisfaction (%)", satisfactionSurvey);
});
</script>
