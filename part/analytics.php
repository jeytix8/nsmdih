<?php
include('connect.php');

$selectedSection = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : '';

$sectionCounts = [];
$jobOrderCounts = [];
$totalJobOrders = 0;

// Query section job order counts
$querySectionCounts = "SELECT section, COUNT(*) as count FROM records_job_order GROUP BY section ORDER BY section ASC";
$resultSectionCounts = $conn->query($querySectionCounts);
while ($row = $resultSectionCounts->fetch_assoc()) {
    $sectionCounts[$row['section']] = $row['count'];
    $totalJobOrders += $row['count'];
}

// Query job order nature counts
$queryJobOrders = "SELECT job_order_nature, COUNT(*) as count FROM records_job_order GROUP BY job_order_nature ORDER BY job_order_nature ASC";
$resultJobOrders = $conn->query($queryJobOrders);
while ($row = $resultJobOrders->fetch_assoc()) {
    $jobOrderCounts[$row['job_order_nature']] = $row['count'];
}
?>

<style>
    #sectionChartLogs, #barChartLogs {
        width: 100% !important;
        height: 300px !important;
    }
</style>

<div id="chart-container" class="container-fluid print-area">
    <div style="display: flex; flex-wrap: wrap; height: 100%;">
        <!-- First Chart: Job Orders per Section (Bar Chart) -->
        <div class="card" style="width: 49%; height: 100%; margin-right: 5px;">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span class="fs-2hx fw-bold text-black-900 me-2"><?php echo number_format($totalJobOrders); ?></span>
                        <span class="fs-4 fw-semibold me-1">📝</span>
                        <form id="sectionForm">
                            <label for="section">Select Section:</label>
                            <select name="section" id="section">
                                <option value="">Overall</option>
                                <?php foreach ($sectionCounts as $section => $count): ?>
                                    <option value="<?php echo $section; ?>" <?php echo ($section == $selectedSection) ? 'selected' : ''; ?>>
                                        <?php echo $section; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                    <span class="text-black-500 pt-4 fw-semibold fs-6">Job Orders by Section</span>
                </div>
            </div>
            <div class="card-body pt-1 pb-0 d-flex align-items-center">
                <canvas id="sectionChartLogs"></canvas>
            </div>
        </div>

        <!-- Second Chart: Job Order Types (Bar Chart) -->
        <div class="card" style="width: 49%; height: 100%;">
            <div class="card-header pt-5">
                <div class="card-title">
                    <span class="text-gray-500 pt-4 fw-semibold fs-6"><?php echo !empty($selectedSection) ? $selectedSection : "Overall"; ?> : Job Order Types</span>
                </div>
            </div>
            <div class="card-body pt-3 pb-4 d-flex align-items-center">
                <canvas id="barChartLogs"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="assets/chart/chart.js"></script>
<script src="assets/chart/chartjs-plugin-datalabels.js"></script>

<script>
let sectionChart, barChart;

$(document).ready(function () {
    $('#section').on('change', function () {
        let selectedSection = $(this).val();
        fetchChartData(selectedSection);
    });

    fetchChartData(); // Load charts initially
});

function fetchChartData(selectedSection = '') {
    $.ajax({
        url: 'part/fetch_chart_data.php',
        type: 'GET',
        data: { section: selectedSection },
        dataType: 'json',
        success: function (response) {
            updateCharts(response);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });
}

function updateCharts(data) {
    if (sectionChart) sectionChart.destroy();
    if (barChart) barChart.destroy();

    const sectionCtx = document.getElementById('sectionChartLogs').getContext('2d');
    sectionChart = new Chart(sectionCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(data.sectionCounts),
            datasets: [{
                label: 'Job Orders per Section',
                data: Object.values(data.sectionCounts),
                backgroundColor: '#4F81BD',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: (value) => value,
                    color: 'black',
                    font: { size: 14 }
                }
            },
            scales: {
                x: { grid: { color: 'gray' } },
                y: { beginAtZero: true, grid: { color: 'gray' } }
            }
        }
    });

    const barCtx = document.getElementById('barChartLogs').getContext('2d');
    barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(data.jobOrderCounts),
            datasets: [{
                label: 'Job Orders per Type',
                data: Object.values(data.jobOrderCounts),
                backgroundColor: '#76B7B2',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: (value) => value,
                    color: 'black',
                    font: { size: 14 }
                }
            },
            scales: {
                x: { grid: { color: 'gray' } },
                y: { beginAtZero: true, grid: { color: 'gray' } }
            }
        }
    });
}
</script>
