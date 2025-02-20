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
                <th onclick="sortTable('assign_to')">Assign To<i class='fas fa-sort'></i></th> <!-- Dropdown -->
                <th onclick="sortTable('status')">Status<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('timestamp_received')">Timestamp Received<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('computer_name')">Computer Name<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('model')">Model<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('ip_address')">IP Address<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('operating_system')">Operating System<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('remarks')">Remarks<i class='fas fa-sort'></i></th>
                <th onclick="sortTable('timestamp_remarks')">Timestamp Remarks<i class='fas fa-sort'></i></th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded dynamically from update_status_admin.php -->
        </tbody>
    </table>

    <div id="resolvedModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h3>Enter Details for Resolved Case</h3>
            <label>Computer Name</label>
            <input type="text" id="computer_name">
            
            <label>Model</label>
            <input type="text" id="model">
            
            <label>IP Address</label>
            <input type="text" id="ip_address">
            
            <label>Operating System</label>
            <input type="text" id="operating_system">
            
            <label>Remarks</label>
            <textarea id="remarks"></textarea>

            <button id="confirmResolve" class="confirm-button">Confirm</button>
            <button id="cancelResolve" class="confirm-button">Cancel</button>
        </div>
    </div>

</div>

<script>
$(document).ready(function () {
    loadTableData();

    // Store previous status before change
    $(document).on("focus", ".status-dropdown", function () {
        $(this).data("previous", $(this).val()); // Store the previous value
    });

    $(document).on("change", ".status-dropdown", function () {
        let id = $(this).data("id");
        let newStatus = $(this).val();
        let previousStatus = $(this).data("previous"); // Get the stored previous value

        if (newStatus === "Resolved" || newStatus === "On Hold") {
            // Fetch existing data before showing modal
            $.ajax({
                url: "part/fetch_joborder_adminremarks.php", // New PHP file to fetch details
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        $("#computer_name").val(data.computer_name || "");
                        $("#model").val(data.model || "");
                        $("#ip_address").val(data.ip_address || "");
                        $("#operating_system").val(data.operating_system || "");
                        $("#remarks").val(data.remarks || "");
                    } else {
                        alert("Failed to fetch details!");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX error:", error);
                },
            });

            // Show modal
            $("#resolvedModal").show();

            // Handle confirm button click
            $("#confirmResolve").off("click").on("click", function () {
                let computer_name = $("#computer_name").val().trim();
                let model = $("#model").val().trim();
                let ip_address = $("#ip_address").val().trim();
                let operating_system = $("#operating_system").val().trim();
                let remarks = $("#remarks").val().trim();

                if (!remarks) {
                    alert("Remarks field is required!");
                    return;
                }

                // Proceed with updating status
                updateStatus(id, newStatus, computer_name, model, ip_address, operating_system, remarks);
                $("#resolvedModal").hide();
            });

            // Handle cancel button click
            $("#cancelResolve, #closeModal").off("click").on("click", function () {
                $("#resolvedModal").hide();
                $(`.status-dropdown[data-id='${id}']`).val(previousStatus); // Revert to previous status
            });

        } else {
            // Directly update status if not "Resolved" or "On Hold"
            updateStatus(id, newStatus);
        }
    });
    // Handle search input
    $("#search-bar").on("keyup", function () {
        searchTable();
    });
});


function updateStatus(id, newStatus, computer_name = '', model = '', ip_address = '', operating_system = '', remarks = '') {
    $.ajax({
        url: 'part/update_status_admin.php',
        type: 'POST',
        data: { 
            id: id, 
            status: newStatus, 
            computer_name: computer_name,
            model: model,
            ip_address: ip_address,
            operating_system: operating_system,
            remarks: remarks
        },
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            loadTableData(); // Reload table after update
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}


function loadTableData() {
    let searchValue = $("#search-bar").val().trim();
    let sortBy = $("#issue_log_table").data("sort_by") || "id";  // Default sorting column
    let order = $("#issue_log_table").data("order") || "asc";    // Default order

    $.ajax({
        url: "part/update_status_admin.php",
        type: "GET",
        data: { search: searchValue, sort_by: sortBy, order: order },
        success: function (data) {
            $("#issue_log_table tbody").html(data);
        }
    });
}

// Function to sort table while keeping search value
function sortTable(column) {
    let currentOrder = $("#issue_log_table").data("order") || "asc";
    let newOrder = currentOrder === "asc" ? "desc" : "asc";

    $("#issue_log_table").data("sort_by", column);
    $("#issue_log_table").data("order", newOrder);

    loadTableData(); // Reload table with new sorting
}

// Function to search while keeping sorting order
function searchTable() {
    loadTableData(); // Reload table with new search
}


function printPage() {
    window.print();
}

</script>
