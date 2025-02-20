<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}
?>

<style>
    .issue-log-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 10px;
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
        font-size: 11px;
    }
    .issue-log-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .issue-log-table tr:hover {
        background-color: #f1f1f1;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .confirm-button {
        background-color: #006735; 
        color: white;             
        border: none;              
        padding: 7px 7px;       
        text-align: center;        
        text-decoration: none;     
        display: inline-block;     
        margin: 4px 2px;         
        cursor: pointer;          
        border-radius: 5px;    
    }
    .confirm-button:hover {
        background-color: #45a049; 
    }
    .selects {
        border: solid black;
        padding: 5px 5px;
        border-radius: 5px;
    }

    #cancelUpdate{
        background-color: white !important;
        color: black;
         padding: 7px 7px;       
        text-align: center;        
        text-decoration: none;     
        display: inline-block;     
        margin: 4px 2px;         
        cursor: pointer;          
        border-radius: 5px;    
        border: solid gray 1px;

    }

     .button-container2 {
        display: flex;
        justify-content: space-between;
        margin: 20px;

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

    .assign-to-dropdown {
        height: 30px;
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

   /* Dropdown button and content styling */
.dropdown2 {
    position: relative; /* Needed for dropdown positioning */
    display: flex;
    align-items: center;
}

.dropdown2-btn {
    background-color: white;
    border: 1px solid #ccc;
    padding: 12px 12px;
    cursor: pointer;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 33px;
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
    width: 600px;
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

/* Layout of filter sections inside the dropdown */
.row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap; /* Allows columns to wrap to the next line if space is tight */
    gap: 10px; /* Add space between columns */
    margin: 6px;
}

.col {
    flex: 1; /* Distribute space evenly across columns */
    text-align: left; /* Align text and checkboxes to the left */
    font-size: 10px;
}

.filter-title {
    font-size: 12px;
}
.filter-title2{
    font-size: 12px;
    margin-top: 6px;
}

/* Styling the filters to be block elements */
#year_month_filter, #section_filter, #nature_filter, #assign_filter, #status_filter {
    display: block;
}

/* Styling individual checkbox labels within each filter section */
#year_month_filter label,
#section_filter label,
#nature_filter label,
#assign_filter label,
#status_filter label {
    display: inline-flex; /* Align items horizontally */
    margin-bottom: -15px;
}

/* Optional: Add additional styling for individual checkboxes */
input[type="checkbox"] {
    margin-right: 4px;
}

    .button {
        background-color: #1a0c80;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #3725b3;
    }
</style>

    <div id="issue_ticket">
        <div class="button-container2">
            <!-- Filter and Search Section -->
            <div class="filter-search-container">
                <!-- Filtering Dropdown with Clickable Button -->
                <div class="search-bar-container">
                    <input type="text" id="search-bar" placeholder="Search" onkeyup="fetchData()">
                </div>
                <div class="dropdown2">
                    <button class="dropdown2-btn">
                        <i style="color: black;" class="bi bi-funnel-fill"></i>
                    </button>
                    <div class="dropdown2-content">
                        <div class="row">
                            <div class="col">
                                <h3 class="filter-title">Filter by Assign To</h3>
                                <div id="assign_filter"></div>
                            </div>
                            <div class="col">
                                <h3 class="filter-title">Filter by Status</h3>
                                <div id="status_filter"></div>
                            </div>
                            <div class="col">
                                <h3 class="filter-title">Filter by Nature of Job Order</h3>
                                <div id="nature_filter"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="filter-title2">Filter by Month</h3>
                                <div id="year_month_filter"></div>
                            </div>
                            <div class="col">
                                <h3 class="filter-title2">Filter by Section</h3>
                                <div id="section_filter"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print button -->
            <button class="button" onclick="printPage()">Print This Page</button>
        </div>
    </div>

    <table class='issue-log-table' id='issue_log_table'>
        <thead>
            <tr>
                <th onclick="sortTable('id')">ID<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('issue_date')">Timestamp<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('name')">Name<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('section')">Section<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('job_order_nature')">Nature of Job Order<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('description')">Description<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('assign_to')">Assign To<i class='fas fa-sort'></i></th> <!-- Dropdown -->
                <th onclick="sortTable('status')">Status<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('timestamp_received')">Timestamp Received<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('computer_name')">Computer Name<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('model')">Model<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('ip_address')">IP Address<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('operating_system')">Operating System<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('remarks')">Remarks<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('timestamp_remarks')">Timestamp Remarks<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('satisfied')">Satisfied<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('unsatisfied')">Unsatisfied<i class='fas fa-sort'></i></th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded dynamically from update_status_admin.php -->
        </tbody>
    </table>

<script>
$(document).ready(function() {
    loadTableData();  // Initial load of table
    loadFilters12();   // Load the filters

    // Search bar input handler
    $('#search-bar').on('keyup', function() {
        fetchData(); // Re-fetch data when user types in search bar
    });

    // Filter change handler
    $(document).on('change', 'input[type="checkbox"]', function() {
        fetchData(); // Re-fetch data when any filter changes
    });
});

// Function to load table data (fetch only, no updates)
function loadTableData() {
    $.get('part/fetch_records.php', function(data) {
        $('#issue_log_table tbody').html(data);
    });
}

// Function to sort the table
function sortTable(column) {
    let currentOrder = localStorage.getItem('sortOrder') || 'asc';
    let newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

    localStorage.setItem('sortOrder', newOrder);
    localStorage.setItem('sortColumn', column);

    fetchData(); // Fetch updated data with new sorting
}


// Apply sorting and search when the page loads
$(document).ready(function() {
    fetchData();  // Load data with sorting and search
});

// Function to handle searching and filtering
function fetchData() {
    let searchValue = $('#search-bar').val().trim();
    let sortBy = localStorage.getItem('sortColumn') || 'id';
    let order = localStorage.getItem('sortOrder') || 'asc';

    // Collect selected filters
    let filters = {
        search: searchValue,  // Include the search term
        sort_by: sortBy,
        order: order
    };

    // Collect selected checkboxes for each filter
    $('input.year-month-filter:checked').each(function() {
        if (!filters.year_month) filters.year_month = [];
        filters.year_month.push($(this).val());
    });

    $('input.section-filter:checked').each(function() {
        if (!filters.section) filters.section = [];
        filters.section.push($(this).val());
    });

    $('input.nature-filter:checked').each(function() {
        if (!filters.nature) filters.nature = [];
        filters.nature.push($(this).val());
    });

    $('input.assign-filter:checked').each(function() {
        if (!filters.assign) filters.assign = [];
        filters.assign.push($(this).val());
    });

    $('input.status-filter:checked').each(function() {
        if (!filters.status) filters.status = [];
        filters.status.push($(this).val());
    });

    // Send the AJAX request with both search and filters
    $.ajax({
        url: 'part/fetch_records.php',
        type: 'GET',
        data: filters,  // Send all filters (search + selected filters)
        success: function(data) {
            $('#issue_log_table tbody').html(data);  // Update the table
        }
    });
}

// Apply sorting and search when the page loads
$(document).ready(function() {
    fetchData(); // Load initial data with sorting and search applied
});


function loadFilters12() {
    $.ajax({
        url: 'part/fetch_filters.php', // Fetch filter data from your server
        type: 'GET',
        success: function(data) {
            const filters = JSON.parse(data);

            // Year and Month filter checkboxes
            filters.year_month.forEach(item => {
                $('#year_month_filter').append(`<label><input type="checkbox" class="year-month-filter" value="${item}">${item}</label><br>`);
            });

            // Section filter checkboxes
            filters.section.forEach(section => {
                $('#section_filter').append(`<label><input type="checkbox" class="section-filter" value="${section}">${section}</label><br>`);
            });

            // Nature of Job Order filter checkboxes
            filters.nature.forEach(nature => {
                $('#nature_filter').append(`<label><input type="checkbox" class="nature-filter" value="${nature}">${nature}</label><br>`);
            });

            // Assign To filter checkboxes
            filters.assign.forEach(assign => {
                $('#assign_filter').append(`<label><input type="checkbox" class="assign-filter" value="${assign}">${assign}</label><br>`);
            });

            // Status filter checkboxes
            filters.status.forEach(status => {
                $('#status_filter').append(`<label><input type="checkbox" class="status-filter" value="${status}">${status}</label><br>`);
            });
        }
    });
}

// Update the filterData12 function to handle all selected filters
function filterData12() {
    let filters = {
        year_month: [],
        section: [],
        nature: [],
        assign: [],
        status: []
    };

    // Collect selected checkboxes for each category
    $('input.year-month-filter:checked').each(function() {
        filters.year_month.push($(this).val());
    });

    $('input.section-filter:checked').each(function() {
        filters.section.push($(this).val());
    });

    $('input.nature-filter:checked').each(function() {
        filters.nature.push($(this).val());
    });

    $('input.assign-filter:checked').each(function() {
        filters.assign.push($(this).val());
    });

    $('input.status-filter:checked').each(function() {
        filters.status.push($(this).val());
    });

    // Send AJAX request with filters
    $.ajax({
        url: 'part/fetch_records.php',
        type: 'GET',
        data: filters, // Send filters as an object
        success: function(data) {
            $('#issue_log_table tbody').html(data);
        }
    });
}


// Function to fetch filtered data and reload the table
function loadTableData12(filters) {
    $.ajax({
        url: 'part/fetch_records.php',
        type: 'GET',
        data: filters,
        success: function(data) {
            $('#issue_log_table tbody').html(data);
        }
    });
}

function printPage() {
    window.print();
}
</script>
