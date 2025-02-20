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
        font-size: 11px;
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
                    <input type="text" id="search-bar" placeholder="Search" onkeyup="searchTable()">
                </div>
            </div>

            <!-- Print button -->
            <button class="button" onclick="printPage()">Print This Page</button>
        </div>
    </div>

    <table class='issue-log-table' id='issue_log_table'>
        <thead>
            <tr>
                <th data-column="id">ID <i class='fas fa-sort'></i></th>
                <th data-column="issue_date">Timestamp <i class='fas fa-sort'></i></th>
                <th data-column="name">Name <i class='fas fa-sort'></i></th>
                <th data-column="section">Section <i class='fas fa-sort'></i></th>
                <th data-column="job_order_nature">Nature of Job Order <i class='fas fa-sort'></i></th>
                <th data-column="description">Description <i class='fas fa-sort'></i></th>
                <th data-column="assign_to">Assign To <i class='fas fa-sort'></i></th>
                <th data-column="status">Status <i class='fas fa-sort'></i></th>
                <th data-column="timestamp_received">Timestamp Received <i class='fas fa-sort'></i></th>
                <th data-column="remarks">Remarks <i class='fas fa-sort'></i></th>
                <th data-column="timestamp_remarks">Timestamp Remarks <i class='fas fa-sort'></i></th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded dynamically from update_status_superadmin.php -->
        </tbody>
    </table>

</div>

<script>
$(document).ready(function() {
    loadTableData();

    // Update "Assign To" and "Status" when dropdown is changed
    $(document).on('change', '.assign-to-dropdown', function() {
        let id = $(this).data('id');
        let assignTo = $(this).val();
        updateAssignment(id, assignTo);
    });

    // Handle searching dynamically
    $('#search-bar').on('keyup', function() {
        let searchValue = $(this).val().trim();
        let sortBy = $('#issue_log_table').data('sort_by') || 'id';
        let order = $('#issue_log_table').data('order') || 'DESC';
        loadTableData(searchValue, sortBy, order);
    });

    // Handle sorting when a column is clicked
    $('.issue-log-table th').on('click', function() {
        let column = $(this).data('column'); // Get column name from data attribute
        if (!column) return; // Ignore if no column specified

        let currentOrder = $('#issue_log_table').data('order') || 'ASC';
        let newOrder = (currentOrder === 'ASC') ? 'DESC' : 'ASC';

        $('#issue_log_table').data('order', newOrder);
        $('#issue_log_table').data('sort_by', column);

        let searchValue = $('#search-bar').val().trim(); // Retain search value
        loadTableData(searchValue, column, newOrder);
    });

});

// Function to update assignment & status via AJAX
function updateAssignment(id, assignTo) {
    $.ajax({
        url: 'part/update_status_superadmin.php',
        type: 'POST',
        data: { id: id, assign_to: assignTo },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            $(`.status-column[data-id='${id}']`).text(response.status);
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

// Function to load table data with sorting, searching, and filtering
function loadTableData(search = '', sort_by = 'id', order = 'DESC') {
    $.ajax({
        url: 'part/update_status_superadmin.php',
        type: 'GET',
        data: { search: search, sort_by: sort_by, order: order },
        success: function(data) {
            $('#issue_log_table tbody').html(data);
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

// Function to handle searching
function searchTable() {
    let searchValue = $('#search-bar').val().trim();
    loadTableData(searchValue);
}


function sortTable12(column) {
    var order12 = $('#faculty_log').data('order12') === 'asc' ? 'desc' : 'asc';
    $('#faculty_log').data('order12', order12);
    $('#faculty_log').data('sort_by12', column); 
    filterData12();
}


function printPage() {
    window.print();
}


// Function to handle sorting
function sortTable(column) {
    let currentOrder = $('#issue_log_table').data('order') || 'ASC';
    let newOrder = currentOrder === 'ASC' ? 'DESC' : 'ASC';
    $('#issue_log_table').data('order', newOrder);
    loadTableData('', column, newOrder);
}

</script>