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
        background-color: #2a1aa1;
        color: black;
        cursor: pointer;
        color: whitesmoke;
    }
    .issue-log-table tr:nth-child(odd) {
        background-color: rgba(26, 12, 128, 0.06); /* 2% opacity */
    }
    .issue-log-table tr:nth-child(even) {
        background-color: rgba(26, 12, 128, 0.03); /* 2% opacity */
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

    .button {
        background-color: #2a1aa1;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #3725b3;
    }

    .rate-btn {
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
    }

    .rate-btn.active {
        background-color: #2a1aa1;
        color: white;
    }

    .rate-btn.disabled {
        background-color: rgba(26, 12, 128, 0.3); /* 2% opacity */
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
    .modal-content h1{
        text-align: center;
        padding-bottom: 20px;
    }
    .close {
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        text-align: center;
        width: 30px;
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
        background-color: #1a0c80;
        color: white;
    }
    .rating-table input[type="radio"] {
        transform: scale(1.2);
    }
    .button-container {
        text-align: center; /* Centers inline elements like buttons */
        margin-top: 15px; /* Adjust spacing */
    }
    .confirm-button {
        background-color: #1a0c80;
        color: white;             
        border: none;              
        padding: 7px 7px;   
        text-decoration: none;     
        display: inline-block;     
        margin: 4px 2px;         
        cursor: pointer;          
        border-radius: 5px;    
    }
    .confirm-button:hover {
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
            <h1>Satisfaction Survey</h1>
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
                <div class="button-container">
                    <button type="submit" class="confirm-button">Submit Rating</button>
                </div>
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

// Function to handle searching
function searchTable() {
    let searchValue = $('#search-bar').val().trim();
    
    // If search input is empty, reset the table to its default state
    if (searchValue === "") {
        // Call the same PHP script but without any search query parameter
        $.ajax({
            url: 'part/status_joborder_fetch_rate.php',
            type: 'GET',
            success: function(data) {
                if (data.success) {
                    let tableRows = '';
                    data.data.forEach(row => {
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
                    console.error("Error fetching data: ", data.message);
                }
            }
        });
    } else {
        // Perform search if there is text in the search bar
        $.ajax({
            url: 'part/status_joborder_fetch_rate.php',
            type: 'GET',
            data: { search: searchValue },
            success: function(data) {
                if (data.success) {
                    let tableRows = '';
                    data.data.forEach(row => {
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
                    console.error("Error fetching data: ", data.message);
                }
            }
        });
    }
}



function printPage() {
    window.print();
}
</script>
