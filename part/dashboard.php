<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure the user is logged in (secured session)
if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection file
include('connect.php');
include 'analytics.php';

// ----------------- Fetch Data for section and PC Counts for Logs -----------------
$querysections = "SELECT DISTINCT section FROM records_job_order ORDER BY section ASC";
$resultsections = $conn->query($querysections);
$sections = [];
if ($resultsections && $resultsections->num_rows > 0) {
    while ($row = $resultsections->fetch_assoc()) {
        $sections[] = $row['section'];
    }
}

$selectedsection = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : '';

// Query to get section counts for the doughnut chart (all sections)
$sectionCounts = [];
$totalCountsections = 0;
$querysectionCounts = "SELECT section, COUNT(*) as count FROM records_job_order GROUP BY section ORDER BY section ASC";
$resultsectionCounts = $conn->query($querysectionCounts);
if ($resultsectionCounts && $resultsectionCounts->num_rows > 0) {
    while ($row = $resultsectionCounts->fetch_assoc()) {
        $sectionCounts[$row['section']] = $row['count'];
        $totalCountsections += $row['count'];
    }
}

$pcCounts = [];
$totalCountPCs = 0;

if ($selectedsection) {
    // Prepared statement to fetch PC counts for the selected section
    $queryPCs = $conn->prepare("SELECT satisfied, COUNT(*) as count FROM records_job_order WHERE section = ? GROUP BY satisfied ORDER BY satisfied ASC");
    $queryPCs->bind_param("s", $selectedsection);
    $queryPCs->execute();
    $resultPCs = $queryPCs->get_result();

    if ($resultPCs && $resultPCs->num_rows > 0) {
        while ($row = $resultPCs->fetch_assoc()) {
            $pcCounts[$row['satisfied']] = $row['count'];
            $totalCountPCs += $row['count'];
        }
    } else {
        $pcCounts = ['No data' => 0];
    }
} else {
    foreach ($sectionCounts as $section => $count) {
        $queryPCsAllsections = $conn->prepare("SELECT satisfied, COUNT(*) as count FROM records_job_order WHERE section = ? GROUP BY satisfied");
        $queryPCsAllsections->bind_param("s", $section);
        $queryPCsAllsections->execute();
        $resultPCsAllsections = $queryPCsAllsections->get_result();

        while ($row = $resultPCsAllsections->fetch_assoc()) {
            $pcCounts[$row['satisfied']] = isset($pcCounts[$row['satisfied']]) ? $pcCounts[$row['satisfied']] + $row['count'] : $row['count'];
            $totalCountPCs += $row['count'];
        }
    }
}

// ----------------- Fetch Data for Remarks and PC Counts for Issues -----------------
$sectionquery = "SELECT DISTINCT section FROM records_job_order ORDER BY section ASC";
$resultissuesection = $conn->query($sectionquery);
$sectionissue = [];
if ($resultissuesection && $resultissuesection->num_rows > 0) {
    while ($row = $resultissuesection->fetch_assoc()) {
        $sectionissue[] = $row['section'];
    }
}

$selectedissuesection = isset($_GET['issue_section']) ? $conn->real_escape_string($_GET['issue_section']) : '';

$sectioncount = [];
$totalissuecountsections = 0;
$totalquerysectioncounts = "SELECT section, COUNT(*) as count1 FROM records_job_order GROUP BY section ORDER BY section ASC";
$resultissuesectioncounts = $conn->query($totalquerysectioncounts);
if ($resultissuesectioncounts && $resultissuesectioncounts->num_rows > 0) {
    while ($row = $resultissuesectioncounts->fetch_assoc()) {
        $sectioncount[$row['section']] = $row['count1'];
        $totalissuecountsections += $row['count1'];
    }
}

$issuepccounts = [];
$totalissuecountpcs = 0;

if ($selectedissuesection) {
    $queryissuePCs = $conn->prepare("SELECT satisfied, COUNT(*) as count1 FROM records_job_order WHERE section = ? GROUP BY satisfied ORDER BY satisfied ASC");
    $queryissuePCs->bind_param("s", $selectedissuesection);
    $queryissuePCs->execute();
    $resultissuePCs = $queryissuePCs->get_result();

    if ($resultissuePCs && $resultissuePCs->num_rows > 0) {
        while ($row = $resultissuePCs->fetch_assoc()) {
            $issuepccounts[$row['satisfied']] = $row['count1'];
            $totalissuecountpcs += $row['count1'];
        }
    } else {
        $issuepccounts = ['No data' => 0];
    }
} else {
    foreach ($sectioncount as $section => $count1) {
        $issuequeryPCsAllsections = $conn->prepare("SELECT satisfied, COUNT(*) as count1 FROM records_job_order WHERE section = ? GROUP BY satisfied");
        $issuequeryPCsAllsections->bind_param("s", $section);
        $issuequeryPCsAllsections->execute();
        $resultissuePCsAllsections = $issuequeryPCsAllsections->get_result();

        while ($row = $resultissuePCsAllsections->fetch_assoc()) {
            $issuepccounts[$row['satisfied']] = isset($issuepccounts[$row['satisfied']]) ? $issuepccounts[$row['satisfied']] + $row['count1'] : $row['count1'];
            $totalissuecountpcs += $row['count1'];
        }
    }
}

// Close the database connection
$conn->close();
?>


    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
         .card {
    display: flex;
    flex-direction: column;
    width: 25%;
    height: 300px;
    margin-right: 5px;
     padding: 0px !important;
}

.card-body {
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 0px !important;

}

canvas {
    width: 100%;
    height: 100%;
}

            .no-print {
                display: none;
            }
        }

        .button {
            padding: 5px 20px;
            color: white;
            background-color: #006735;
            border: solid;
            border-radius: 7px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
        }

        h1 {
            text-align: center;
            margin: 5px;
            padding: 3px;
            font-family: 'Arial', sans-serif;
            font-size: 1.7em;
            color: #e0f7e0;
            background-color: #006735;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .card {
            background-color: #E5F6DF;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
           
        }

        .card-header, .card-title {
            color: black !important;
        }

        .card-body {
            height: 100%;
        }
    </style>


     <div id="dashboard">
    <div class="container-fluid print-area">
    <button class="button no-print" onclick="printPage()">Print This Page</button>
    
            <!-- Doughnut Chart for Records Log (section-wise) -->
            <div style="display: flex; flex-wrap: wrap; height: auto; ">
    <!-- First Chart: section Logs Count -->
    <div class="card card-flush mb-0 mb-xl-10" style="width: 25%; height: 100%; margin-right: 5px;">
        <div class="card-header pt-5">
            <div class="card-title d-flex flex-column">
                <div class="d-flex align-items-center">
                    <span class="fs-2hx fw-bold text-black-900 me-2 lh-1 ls-n2"><?php echo number_format($totalCountPCs); ?></span>
                    <span class="fs-4 fw-semibold me-1 align-self-start">📝</span>
                   <form method="get">
    <label for="section" style="font-size: 13px;">Select section:</label>
    <select style="font-size: 13px;" name="section" id="section" onchange="this.form.submit()">
        <option style="font-size: 13px;" value="">Overall</option>
        <?php foreach ($sections as $section): ?>
            <option style="font-size: 13px;" value="<?php echo $section; ?>" <?php echo $section == $selectedsection ? 'selected' : ''; ?>>
                <?php echo $section; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <!-- Preserve the selectedissuesection in the URL -->
    <input type="hidden" name="issue_section" value="<?php echo htmlspecialchars($selectedissuesection); ?>">
</form>
                </div>
                <span class="text-black-500 pt-4 fw-semibold fs-6">Logs Count by section</span>
            </div>
        </div>
        <div class="card-body pt-1 pb-0 d-flex align-items-center" style="height: 100%;">
            <div class="d-flex flex-center me-0 pt-0" style="width: 100%; height: 100%;">
                <canvas style="width:100%; display: flex; height:200px; position: relative; " id="sectionChartLogs"></canvas>
            </div>
        </div>
    </div>

    <!-- Second Chart: PC Logs Count -->
    <div class="card card-flush mb-5 mb-xl-10" style="width: 74.3%; height: 100%;">
        <div class="card-header pt-5">
            <div class="card-title d-flex flex-column">
                <div class="d-flex align-items-center">
                    <span class="fs-2hx fw-bold text-black-900 me-2 lh-1 ls-n2"></span>
                    <span class="fs-4 fw-semibold me-1 align-self-start">
                        <img width="23" height="23" src="workstation.png" alt="workstation"/>
                    </span>
                </div>
                <span class="text-gray-500 pt-4 fw-semibold fs-6" style="color:black !important;"><?php echo !empty($selectedsection) ? $selectedsection : "Overall"; ?> : PC Logs</span>
            </div>
        </div>
        <div class="card-body pt-3 pb-4 d-flex align-items-center" style="height: 100%;">
            <div class="d-flex flex-center me-5 pt-2" style="width: 100%; height: 100%;">
                <canvas style="width:100%; display: flex; height:200px;   position: relative;" id="barChartLogs"></canvas>
            </div>
        </div>
    </div>

    <!-- Third Chart: Issues Count by section -->
    <div class="card card-flush mb-5 mb-xl-10" style="width: 25%; height: 100%; margin-right: 5px;">
        <div class="card-header pt-5">
            <div class="card-title d-flex flex-column">
                <div class="d-flex align-items-center">
                    <span class="fs-2hx fw-bold text-black-900 me-2 lh-1 ls-n2"><?php echo number_format($totalissuecountpcs); ?></span>
                    <span class="fs-4 fw-semibold me-1 align-self-start">⚠️</span>
                    <form method="get">
    <label for="issue_section" style="font-size: 13px;">Select section:</label>
    <select style="font-size: 13px;" name="issue_section" id="issue_section" onchange="this.form.submit()">
        <option style="font-size: 13px;" value="">Overall</option>
        <?php foreach ($sectionissue as $issuesection): ?>
            <option style="font-size: 13px;" value="<?php echo $issuesection; ?>" <?php echo $issuesection == $selectedissuesection ? 'selected' : ''; ?>>
                <?php echo $issuesection; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <!-- Preserve the selectedsection in the URL -->
    <input type="hidden" name="section" value="<?php echo htmlspecialchars($selectedsection); ?>">
</form>
                </div>
                <span class="text-gray-500 pt-4 fw-semibold fs-6" style="color:black !important;">Issues Count by section</span>
            </div>
        </div>
        <div class="card-body pt-1 pb-0 d-flex align-items-center" style="height: 100%;">
            <div class="d-flex flex-center me-0 pt-0" style="width: 100%; height: 100%;">
                <canvas style="width:100%; display: flex; height:200px;   position: relative;" id="sectionChartIssues"></canvas>
            </div>
        </div>
    </div>

    <!-- Fourth Chart: PC Logs with Issues -->
    <div class="card card-flush mb-5 mb-xl-10" style="width: 74.3%; height: 100%;">
        <div class="card-header pt-5">
            <div class="card-title d-flex flex-column">
                <div class="d-flex align-items-center">
                    <span class="fs-2hx fw-bold text-black-900 me-2 lh-1 ls-n2"></span>
                    <span class="fs-4 fw-semibold me-1 align-self-start">
                        <img width="23" height="23" src="error.png" alt="error"/>
                    </span>
                </div>
                <span class="text-gray-500 pt-4 fw-semibold fs-6" style="color:black !important;"><?php echo !empty($selectedissuesection) ? $selectedissuesection : "Overall"; ?> : PC Logs with Issue</span>
            </div>
        </div>
        <div class="card-body pt-3 pb-4 d-flex align-items-center" style="height: 100%;">
            <div class="d-flex flex-center me-5 pt-2" style="width: 100%; height: 100%;">
                <canvas style="width:100%; display: flex; height:200px;  position: relative;" id="barChartIssues"></canvas>
            </div>
        </div>
    </div>
</div>

</div>
</div>


    



<!-- Chart.js Scripts -->
<script src="assets/chart/chart.js"></script>
<script src="assets/chart/chartjs-plugin-datalabels.js"></script>

<script>
// Register the datalabels plugin
Chart.register(ChartDataLabels);

// Total counts for Logs
const totalLogCount = <?php echo array_sum($sectionCounts); ?>;

// Doughnut Chart for section Counts (Logs)
const sectionCounts = <?php echo json_encode(array_values($sectionCounts)); ?>;
const sectionLabels = <?php echo json_encode(array_keys($sectionCounts)); ?>;

const sectionChartLogs = new Chart(document.getElementById('sectionChartLogs').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: sectionLabels,
        datasets: [{
            label: 'section Log Counts',
            data: sectionCounts,
            backgroundColor: [
                '#4F81BD', '#76B7B2', '#E2725B', '#CCCCFF',
                '#F1916D', '#19305C', '#AE7DAC', '#C48CB3'
            ],
            borderColor: 'rgba(0, 0, 0, 0.1)',
            borderWidth: 1
        }]
    },
    options: {
         maintainAspectRatio: false,
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        const dataValue = tooltipItem.raw;
                        return tooltipItem.label + ': ' + dataValue;
                    }
                }
            },
            legend: {
                display: true,
                position: 'right',
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                formatter: function(value) {
                    const percentage = Math.round((value / totalLogCount) * 100);
                    return percentage + '%';
                },
                color: 'black',
                font: {
                    weight: 'plain',
                    size: 12
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Total counts for Issues
const totalIssueCount = <?php echo array_sum($sectioncount); ?>;

// Doughnut Chart for section Counts (Issues)
const sectionCountsIssues = <?php echo json_encode(array_values($sectioncount)); ?>;
const sectionLabelsIssues = <?php echo json_encode(array_keys($sectioncount)); ?>;

const sectionChartIssues = new Chart(document.getElementById('sectionChartIssues').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: sectionLabelsIssues,
        datasets: [{
            label: 'section Issue Counts',
            data: sectionCountsIssues,
            backgroundColor: [
                '#f6d55c', '#ff6b35', '#2a9d8f', '#FFEB99',
                '#C0C5CE', '#F0EAD6', '#FFDBAC'
            ],
            borderColor: 'rgba(0, 0, 0, 0.1)',
            borderWidth: 1
        }]
    },
    options: {
         maintainAspectRatio: false,
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        const dataValue = tooltipItem.raw;
                        return tooltipItem.label + ': ' + dataValue;
                    }
                }
            },
            legend: {
                display: true,
                position: 'right',
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                formatter: function(value) {
                    const percentage = Math.round((value / totalIssueCount) * 100);
                    return percentage + '%';
                },
                color: 'black',
                font: {
                    weight: 'plain',
                    size: 12
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});






// First chart (barChartLogs)
// First chart (barChartLogs)
const pcCounts = <?php echo json_encode(array_values($pcCounts)); ?>;
const pcLabels = <?php echo json_encode(array_keys($pcCounts)); ?>;
const ctxLogs = document.getElementById('barChartLogs').getContext('2d');
const gradient = ctxLogs.createLinearGradient(0, 0, 400, 0);
gradient.addColorStop(0, '#4F81BD');
gradient.addColorStop(1, '#4C9F70');

const barChartLogs = new Chart(ctxLogs, {
    type: 'bar',
    data: {
        labels: pcLabels,
        datasets: [{
            label: 'PC Log Counts',
            data: pcCounts,
            backgroundColor: gradient,
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'black'
                }
            },
            datalabels: {
                display: true,
                color: 'black',
                font: {
                    weight: 'bold',
                    size: 12
                },
                anchor: 'center', // Position at the top of the bar
                align: 'center'
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    color: 'black',
                },
                ticks: {
                    color: 'black',
                }
            },
            y: {
                grid: {
                    color: 'black',
                },
                ticks: {
                    color: 'black',
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Second chart (barChartIssues)
const issuePcCounts = <?php echo json_encode(array_values($issuepccounts)); ?>;
const issuePcLabels = <?php echo json_encode(array_keys($issuepccounts)); ?>;
const ctxIssues = document.getElementById('barChartIssues').getContext('2d');
const gradient1 = ctxIssues.createLinearGradient(0, 0, 400, 0);
gradient1.addColorStop(0, '#ff6b35');
gradient1.addColorStop(1, '#2a9d8f');

const barChartIssues = new Chart(ctxIssues, {
    type: 'bar',
    data: {
        labels: issuePcLabels,
        datasets: [{
            label: 'PC Issue Counts',
            data: issuePcCounts,
            backgroundColor: gradient1,
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'black'
                }
            },
            datalabels: {
                display: true,
                color: 'black',
                font: {
                    weight: 'bold',
                    size: 12
                },
                anchor: 'center', // Position at the top of the bar
                align: 'center'
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    color: 'black',
                },
                ticks: {
                    color: 'black',
                }
            },
            y: {
                grid: {
                    color: 'black',
                },
                ticks: {
                    color: 'black',
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});


 function printPage() {
        window.print();
    }




</script>
