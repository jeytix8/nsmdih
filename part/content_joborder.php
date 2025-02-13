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
    #status-filter{
        background-color: white;
        color: black;
        padding: 5px;
        text-align: center;
        width: 150px;
    }
    #status-filter option{
        background-color: white;
        color: black;
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
            <!-- Filtering Dropdown with Clickable Button -->
            <div class="search-bar-container">
                <input type="text" id="search-bar" placeholder="Search" onkeyup="searchTable()">
            </div>
            <div class="dropdown2">
                <button class="dropdown2-btn">
                    <i style="color: black;" class="bi bi-funnel-fill"></i>
                </button>
                <div class="dropdown2-content">
                    <select id="status-filter" onchange="applyFilter()">
                        <option value="All">All</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Not Resolved">Not Resolved</option>
                    </select>
                </div>
            </div>

            <!-- Search bar -->
            
        </div>

        <!-- Print button -->
        <button class="button" onclick="printPage()">Print This Page</button>
    </div>
</div>






<!-- Modal Structure -->
<div id="statusModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h5>Confirm Status Update</h5>
        <p id="modalMessage"></p>
        <label for="remarksInput">Remarks</label>
        <textarea id="remarksInput" placeholder="Enter remarks here..." required></textarea>
        <br>
        <button id="confirmUpdate" class="confirm-button">Confirm</button>
        <button id="cancelUpdate" class="confirm-button">Cancel</button>
    </div>
</div>


    <table class='issue-log-table' id='issue_log_table'>
        <thead>
            <tr>
                <th onclick="sortTable('id')">ID <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('issue_date')">Timestamp <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('name')">Name <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('section')">Section <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('job_order_nature')">Nature of Job Order <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('description')">Description <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('assign_to')">Assign To <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('status')">Status <i class='fas fa-sort'></i></th> <!-- Now plain text -->
                <th onclick="sortTable('satisfied')">Satisfied <i class='fas fa-sort'></i></th>
                <th onclick="sortTable('unsatisfied')">Unsatisfied <i class='fas fa-sort'></i></th>
            </tr>
        </thead>
        <tbody>
         
            <?php
          
            ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    loadTableData();

    $('#status-filter').change(function() {
        filterValue = $(this).val();
        filterData('status', filterValue);
    });
});

// Function to load table data
function loadTableData() {
    $.ajax({
        url: 'part/update_status.php',
        type: 'GET',
        success: function(data) {
            $('#issue_log_table tbody').html(data);
        }
    });
}

// Function to filter data
function filterData(column, value) {
    $.ajax({
        url: 'part/update_status.php',
        type: 'GET',
        data: { filter_by: column, filter_value: value },
        success: function(data) {
            $('#issue_log_table tbody').html(data);
        }
    });
}

// Function to sort the table
function sortTable(column) {
    const currentOrder = $('#issue_log_table').data('order') || 'asc';
    const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

    $('#issue_log_table').data('order', newOrder);
    $('#issue_log_table').data('sort_by', column);

    $.ajax({
        url: 'part/update_status.php',
        type: 'GET',
        data: { sort_by: column, order: newOrder },
        success: function(data) {
            $('#issue_log_table tbody').html(data);
        }
    });
}
</script>
