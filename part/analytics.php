<?php
include('connect.php');

$selectedSection = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : '';
$selectedDate = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';

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
#sectionChartLogs, #barChartLogs, #satisfactionChartLogs {
    width: auto !important;
    max-width: 100%;
    height: 300px !important;
    max-height: 350px;
}

.card {
    background-color: rgba(26, 12, 128, 0.05); /* 2% opacity */
}


.card-body {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px;
    height: 100%;
    min-height: 320px;
}

canvas {
    width: 100%;
    height: 100%; 
    object-fit: contain;
}
</style>

<div class="card" style="width: 98%; flex-wrap: wrap; justify-content:center; align-items:center; justify-self: center; height:30px; display: flex; gap: 20px; align-items: center;">
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

    <form id="dateForm">
        <label for="dateFilter">Select Year & Month:</label>
        <select name="dateFilter" id="dateFilter">
            <option value="">Overall</option>
            <?php
            $dateQuery = "SELECT DISTINCT issue_year, issue_month FROM records_job_order ORDER BY issue_year DESC, issue_month DESC";
            $dateResult = $conn->query($dateQuery);
            while ($row = $dateResult->fetch_assoc()) {
                $yearMonth = $row['issue_year'] . '-' . str_pad($row['issue_month'], 2, '0', STR_PAD_LEFT);
                echo "<option value='$yearMonth'>$yearMonth</option>";
            }
            ?>
        </select>
    </form>
</div>

<div id="chart-container" class="container-fluid print-area">
    <div style="display: flex; flex-wrap: wrap; height: 100%;">
        <div class="card" style="width: 50%;">
            <div class="card-header pt-5">
                <div class="card-title d-flex flex-column">
                    <div class="d-flex align-items-center">
                        <span id="totalJobOrders" class="fs-2hx fw-bold text-black-900 me-2"><?php echo number_format($totalJobOrders); ?></span>
                        <span class="fs-4 fw-semibold me-1">📋</span>
                        <span class="fs-5 fw-bold text-black-900 me-2">Total Job Orders</span>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3 pb-3">
                <canvas id="sectionChartLogs"></canvas>
            </div>
        </div>

        <div class="card" style="width: 50%;">
            <div class="card-header pt-5">
                <div class="card-title">
                    <span class="fs-5 fw-bold text-black-900 me-2">🏷️ Nature of Job Orders</span>
                </div>
            </div>
            <div class="card-body pt-3 pb-3">
                <canvas id="barChartLogs"></canvas>
            </div>
        </div>

        <div class="card" style="width: 100%;">
            <div class="card-header pt-5">
                <div class="card-title">
                    <span id="totalSatisfiedRecords" class="fs-2hx fw-bold text-black-900 me-2"><?php echo number_format(0); ?></span>
                    <span class="fs-4 fw-semibold me-1">📝</span>
                    <span class="fs-5 fw-bold text-black-900 me-2">Satisfaction Survey</span>
                </div>
            </div>
            <div class="card-body pt-3 pb-3">
                <canvas id="satisfactionChartLogs"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="assets/chart/chart.js"></script>
<script src="assets/chart/chartjs-plugin-datalabels.js"></script>

<script>
let sectionChart, barChart, satisfactionChart;

$(document).ready(function () {
    $('#section, #dateFilter').on('change', function () {
        let selectedSection = $('#section').val();
        let selectedDate = $('#dateFilter').val();
        fetchChartData(selectedSection, selectedDate);
    });

    fetchChartData(); // ✅ Load initially with default filters
});

function fetchChartData(selectedSection = '', selectedDate = '') {
    $.ajax({
        url: 'part/fetch_chart_data.php',
        type: 'GET',
        data: { section: selectedSection, date: selectedDate },
        dataType: 'json',
        success: function (response) {
            console.log("Filtered Data:", response);

            $("#totalJobOrders").text(response.totalJobOrders.toLocaleString());
            $("#totalSatisfiedRecords").text(response.totalSatisfiedRecords.toLocaleString());
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
    if (satisfactionChart) satisfactionChart.destroy();

    function createChart(ctx, labels, values, labelText, bgColor) {
        return new Chart(ctx, {
            type: 'bar',
            data: { labels: labels, datasets: [{ label: labelText, data: values, backgroundColor: bgColor, borderWidth: 1 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: {
                padding: 6 } } } },
            plugins: [{
                afterDraw: function(chart) { 
                    let ctx = chart.ctx;
                    ctx.font = "11px Calibri";
                    ctx.textAlign = "center";
                    ctx.fillStyle = "black";

                    chart.data.datasets.forEach((dataset, i) => {
                        let meta = chart.getDatasetMeta(i);
                        meta.data.forEach((bar, index) => {
                            let data = dataset.data[index] + (labelText.includes('Satisfaction') ? "%" : ""); 
                            ctx.fillText(data, bar.x, bar.y - 5);
                        });
                    });
                }
            }]
        });
    }

    sectionChart = createChart(document.getElementById('sectionChartLogs').getContext('2d'), Object.keys(data.sectionCounts), Object.values(data.sectionCounts), 'Job Orders per Section', '#4F81BD');
    barChart = createChart(document.getElementById('barChartLogs').getContext('2d'), Object.keys(data.jobOrderCounts), Object.values(data.jobOrderCounts), 'Nature of Job Orders', '#76B7B2');
    satisfactionChart = createChart(document.getElementById('satisfactionChartLogs').getContext('2d'), Object.keys(data.satisfactionCounts), Object.values(data.satisfactionCounts), 'Satisfaction Rate (%)', '#F4A261');
}
</script>
