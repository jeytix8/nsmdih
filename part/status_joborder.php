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

    .assign-to-dropdown {
        height: 30px;
    }

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

    .rate-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
    }

    .rate-btn.active {
        background-color: #007bff;
        color: white;
    }

    .rate-btn.disabled {
        background-color: lightgray;
        color: #666;
        cursor: not-allowed;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
    }
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }
    .close {
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .rating-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    .rating-table th, .rating-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    .rating-table th {
        background-color: #007bff;
        color: white;
    }
    .rating-table input[type="radio"] {
        transform: scale(1.2);
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

    <table class='issue-log-table' id='issue_log_table'>
        <thead>
            <tr>
                <th onclick="sortTable('id')">ID<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('issue_date')">Timestamp<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('name')">Name<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('section')">Section<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('job_order_nature')">Nature of Job Order<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('description')">Description<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('assign_to')">Assign To<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('status')">Status<i class='fas fa-sort'></i></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded dynamically from status_joborder_fetch_rate.php -->
        </tbody>
    </table>

    <!-- Satisfaction Survey Modal -->
    <div id="ratingModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h3>Satisfaction Survey</h3>
            <form id="ratingForm">
                <table class="rating-table">
                    <thead>
                        <tr>
                            <th>Categories</th>
                            <th>Satisfied</th>
                            <th>Unsatisfied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Time of Response</td>
                            <td><input type="radio" name="time_of_response" value="y" required></td>
                            <td><input type="radio" name="time_of_response" value="n" required></td>
                        </tr>
                        <tr>
                            <td>Time of Resolution</td>
                            <td><input type="radio" name="time_of_resolution" value="y" required></td>
                            <td><input type="radio" name="time_of_resolution" value="n" required></td>
                        </tr>
                        <tr>
                            <td>Communication Clarity</td>
                            <td><input type="radio" name="communication_clarity" value="y" required></td>
                            <td><input type="radio" name="communication_clarity" value="n" required></td>
                        </tr>
                        <tr>
                            <td>Quality of Support</td>
                            <td><input type="radio" name="quality_of_support" value="y" required></td>
                            <td><input type="radio" name="quality_of_support" value="n" required></td>
                        </tr>
                        <tr>
                            <td>Professionalism</td>
                            <td><input type="radio" name="professionalism" value="y" required></td>
                            <td><input type="radio" name="professionalism" value="n" required></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="confirm-button">Submit Rating</button>
            </form>
        </div>
    </div>

<script>
$(document).ready(function () {
    loadTableData(); // Load data on page load

    // Handle Rate button click
    $(document).on('click', '.rate-btn', function () {
        let id = $(this).data('id');
        $('#ratingModal').show();
        $('#ratingForm').attr('data-id', id); // Store ID in form attribute
    });

    // Handle rating submission
    $('#ratingForm').on('submit', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let formData = $(this).serializeArray();
        formData.push({ name: 'id', value: id });

        if (confirm("Are you sure you want to submit your rating?")) {
            $.ajax({
                url: 'part/status_joborder_fetch_rate.php',
                type: 'POST',
                data: formData,
                dataType: 'json', // Ensure response is treated as JSON
                success: function (response) {
                    console.log("Server Response:", response); // Log response for debugging
                    if (response.success) {
                        alert("Rating submitted successfully!");
                        $('#ratingModal').hide();
                        loadTableData(); // Refresh table after rating
                    } else {
                        alert("Error: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error submitting rating:", xhr.responseText);
                    alert("Error submitting rating: " + xhr.responseText);
                }
            });
        }
    });

    // Close modal
    $('#closeModal').click(function () {
        $('#ratingModal').hide();
    });
});

// Function to load table data
function loadTableData() {
    $.ajax({
        url: 'part/status_joborder_fetch_rate.php',
        type: 'GET',
        dataType: 'json', // Expect JSON response
        success: function (response) {
            if (response.success) {
                let tableRows = '';
                response.data.forEach(row => {
                    tableRows += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.issue_date}</td>
                            <td>${row.name}</td>
                            <td>${row.section}</td>
                            <td>${row.job_order_nature}</td>
                            <td>${row.description}</td>
                            <td>${row.assign_to}</td>
                            <td>${row.status}</td>
                            <td>${row.button}</td>
                        </tr>
                    `;
                });
                $('#issue_log_table tbody').html(tableRows);
            } else {
                alert("Error fetching table data: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error loading table:", xhr.responseText);
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
        url: 'part/status_joborder_fetch_rate.php',
        type: 'GET',
        data: { sort_by: column, order: newOrder },
        dataType: 'json', // Expect JSON response
        success: function (response) {
            if (response.success) {
                let tableRows = '';
                response.data.forEach(row => {
                    tableRows += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.issue_date}</td>
                            <td>${row.name}</td>
                            <td>${row.section}</td>
                            <td>${row.job_order_nature}</td>
                            <td>${row.description}</td>
                            <td>${row.assign_to}</td>
                            <td>${row.status}</td>
                            <td>${row.button}</td>
                        </tr>
                    `;
                });
                $('#issue_log_table tbody').html(tableRows);
            } else {
                alert("Error fetching sorted data: " + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error sorting table:", xhr.responseText);
        }
    });
}

</script>
