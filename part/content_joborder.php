<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

// Fetch Departments
$departments = [];
$deptQuery = "SELECT DISTINCT department FROM records_job_order ORDER BY department ASC";
$deptResult = $conn->query($deptQuery);
while ($row = $deptResult->fetch_assoc()) {
    $departments[] = $row['department'];
}

// Fetch Job Order Natures
$jobOrderNatures = [];
$natureQuery = "SELECT DISTINCT job_order_nature FROM records_job_order ORDER BY job_order_nature ASC";
$natureResult = $conn->query($natureQuery);
while ($row = $natureResult->fetch_assoc()) {
    $jobOrderNatures[] = $row['job_order_nature'];
}

?>

<style>
    /* Dropdown container */
    #filter-dropdown {
        display: none;
        position: absolute;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        z-index: 10;
        width: 450px; /* Adjust width to fit two columns */
        right: 0; /* Align to the right of the button */
        top: 0; /* Align with the button */
        transform: translateX(101%); /* Move it to the right */
    }

    /* Grid layout for two columns */
    .filter-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Two columns */
        gap: 20px; /* Space between columns */
    }

    /* Style for each filter section */
    .filter-box {
        padding: 10px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .filter-title {
        font-weight: bold;
        margin-bottom: 5px;
    }

    /* Checkbox label styling */
    .filter-box label {
        display: block;
        font-size: 14px;
        cursor: pointer;
        margin: 3px 0;
    }

    /* Scrollable filter content if too many items */
    .filter-content {
        max-height: 200px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .issue-log-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 13px;
        text-align: center;
    }
    .issue-log-table th, .issue-log-table td {
        border: 1px solid #ddd;
        padding: 7px;
    }
    .issue-log-table th {
        background-color: white;
        color: black;
        cursor: pointer;
    }
    .issue-log-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .issue-log-table tr:hover {
        background-color: #f1f1f1;
    }

    .button-container2 {
        display: flex;
        justify-content: space-between;
        margin: 20px;

    }
     .button-container2 .button{
        padding:5px 20px;
        color: white;
        background-color:#006735 ;
        border: solid;
        border-radius: 7px;
        height: 40px;
    }
    .dropdown2-btn{
         padding:5px 20px;
        color: white;
        background-color:#006735 ;
        border: solid;
        border-radius: 7px;
        height: 40px;
    }
    @media print {
        .no-print {
            display: none;
        }
    }
/* Initially hide the dropdown */


.button-container2 {
    display: flex;
    align-items: center;
    justify-content: space-between; 
    margin: 20px;
}

.filter-search-container {
    display: flex;
    align-items: center;
    gap: 15px; /* Minimal space between the filter icon and search bar */
}

.search-bar-container input {
    padding: 5px;
    font-size: 14px;
    width: 200px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.dropdown2 {
    position: relative; /* Needed for dropdown positioning */
    display: flex;
    align-items: center;
}

.dropdown2-btn {
    background-color: white;
    border: 1px solid white;
    border-radius: 4px;
    padding: 5px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 38px; /* Matches the height of the search bar */
    width: 45px; /* Square button for the icon */
}

.dropdown2-content {
    position: absolute;
    top: 101%; /* Dropdown below the button */
    left: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 5px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
    display: none; /* Initially hidden */
    z-index: 10;
    border-radius: 4px;
}

.dropdown2:hover .dropdown2-content {
    display: block; /* Show dropdown on hover */
}

.dropdown2-content select {
    width: 150px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.button {
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3;
}
</style>

<div id="issue_ticket">
    <div class="button-container2">
        <!-- Filter and Search Section -->
        <div class="filter-search-container">
            <div class="search-bar-container">
                <input type="text" id="search-bar" placeholder="Search" onkeyup="searchTable()">
            </div>

            <div class="dropdown2">
                <!-- Filter Button -->
                <button class="dropdown2-btn" onclick="toggleFilterDropdown()">
                    <i style="color: black;" class="bi bi-funnel-fill"></i>
                </button>

                <!-- Filter options (Hidden Initially) -->
                <div id="filter-dropdown">
                    <div class="filter-container">
                        <!-- Department Filters -->
                        <div class="filter-box">
                            <div class="filter-title">Filter by Department</div>
                            <div class="filter-content">
                                <?php foreach ($departments as $dept): ?>
                                    <label>
                                        <input type="checkbox" class="filter-checkbox" name="department" value="<?= $dept; ?>">
                                        <?= $dept; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Job Order Nature Filters -->
                        <div class="filter-box">
                            <div class="filter-title">Filter by Nature of Job Order</div>
                            <div class="filter-content">
                                <?php foreach ($jobOrderNatures as $nature): ?>
                                    <label>
                                        <input type="checkbox" class="filter-checkbox" name="job_order_nature" value="<?= $nature; ?>">
                                        <?= $nature; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Print button -->
        <button class="button" onclick="printPage()">Print This Page</button>
    </div>
</div>

<!-- Table -->
<table class='issue-log-table' id='issue_log_table'>
    <thead>
        <tr>
            <th onclick="sortTable11('id')">ID <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('issue_timestamp')">Timestamp <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('name')">Name <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('department')">Department <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('job_order_nature')">Nature of Job Order <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('description')">Description <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('satisfied')">Satisfied <i class='fas fa-sort'></i></th>
            <th onclick="sortTable11('unsatisfied')">Unsatisfied <i class='fas fa-sort'></i></th>
        </tr>
    </thead>
    <tbody>
        <!-- Data will be loaded here dynamically -->
    </tbody>
</table>

<script>
// Function to get current time in Manila
function getCurrentManilaTime() {
    const options = {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: 'long', 
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false 
    };

    const formatter = new Intl.DateTimeFormat('en-US', options);
    const dateParts = formatter.formatToParts(new Date());
    
    // Extract the parts we want
    const year = dateParts.find(part => part.type === 'year').value;
    const month = dateParts.find(part => part.type === 'month').value; 
    const day = dateParts.find(part => part.type === 'day').value;
    const hour = dateParts.find(part => part.type === 'hour').value;
    const minute = dateParts.find(part => part.type === 'minute').value;
    const second = dateParts.find(part => part.type === 'second').value;
    
    return `${day} ${month} ${year}  ${hour}:${minute}:${second}`;
}

// Function to load table data with optional filter and sort
function loadTableData() {
    if ($('#issue_log_table').length) { 
        $.ajax({
            url: 'part/fetch_jo.php',
            type: 'GET',
            success: function(data) {
                $('#issue_log_table tbody').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error loading table:', error);
                alert('Failed to load data.');
            }
        });
    }
}

$(document).ready(function () {
    // Function to toggle the filter dropdown
    window.toggleFilterDropdown = function () {
        $("#filter-dropdown").toggle();
    };

    // Hide dropdown when clicking outside
    $(document).click(function (event) {
        if (!$(event.target).closest(".dropdown2").length) {
            $("#filter-dropdown").hide();
        }
    });

    // Fetch filtered data dynamically
    function fetchFilteredData() {
        let selectedDepartments = [];
        let selectedNatures = [];

        // Get checked departments
        $("input[name='department']:checked").each(function () {
            selectedDepartments.push($(this).val());
        });

        // Get checked job order natures
        $("input[name='job_order_nature']:checked").each(function () {
            selectedNatures.push($(this).val());
        });

        // AJAX request to update table data
        $.ajax({
            url: "part/fetch_filtered_data.php",
            type: "POST",
            data: { departments: selectedDepartments, natures: selectedNatures },
            success: function (response) {
                $("#issue_log_table tbody").html(response);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", error);
            }
        });
    }

    // Attach event listener to checkboxes
    $(".filter-checkbox").on("change", function () {
        fetchFilteredData();
    });

    // Initial fetch when the page loads
    fetchFilteredData();
});

// Function to sort the table data by column after applying filter
function sortTable11(column) {
    let table = document.getElementById("issue_log_table");
    let currentOrder = table.dataset.order || "asc"; // Default sorting order
    let newOrder = currentOrder === "asc" ? "desc" : "asc"; // Toggle order

    // Store the new sorting order
    table.dataset.order = newOrder;

    // Fetch sorted data
    $.ajax({
        url: "part/fetch_jo.php",
        type: "GET",
        data: {
            sort_by: column,
            order: newOrder
        },
        success: function (data) {
            $("#issue_log_table tbody").html(data);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sorted data:", error);
        }
    });
}

 function printPage() {
    window.print();
}

// Function to search through the table columns (case-insensitive and partial match)
function searchTable() {
    const input = document.getElementById("search-bar");          // Get the search input
    const filter = input.value.trim().toLowerCase();              // Trim spaces and convert to lowercase
    const table = document.getElementById("issue_log_table");      // Get the table
    const rows = table.getElementsByTagName("tr");                 // Get all rows in the table

    // Loop through all table rows (skip the header row, which is at index 0)
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName("td");          // Get all cells in the current row
        let matchFound = false;

        // Loop through each cell in the row and check if it contains the search term
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            // Trim cell content and compare it with the search term
            if (cell && cell.innerText.trim().toLowerCase().includes(filter)) {
                matchFound = true;  // If any cell contains the search term, mark as found
                break;               // Stop checking other cells if one match is found
            }
        }

        // If a match is found, show the row; otherwise, hide it
        if (matchFound) {
            rows[i].style.display = "";  // Show row
        } else {
            rows[i].style.display = "none";  // Hide row
        }
    }
}

</script>
