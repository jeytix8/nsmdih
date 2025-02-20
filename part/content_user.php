<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php';

// Fetch user accounts
$query = "SELECT id_no, id, password, section FROM accounts ORDER BY id_no ASC";
$result = mysqli_query($conn, $query);
?>


<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background-color: white;
        padding: 20px;
        width: 40%;
        margin: 10% auto;
        text-align: center;
        border-radius: 5px;
        position: relative;
    }
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
    }
    .button-container2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    #search-bar {
        width: 100%;
        max-width: 300px;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .insert-btn {
        background-color: #388e3c;
        color: white;
        padding: 10px 15px;
        font-size: 14px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        margin-left: 10px;
    }
    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 13px;
        text-align: center;
    }
    .user-table th, .user-table td {
        border: 1px solid #ddd;
        padding: 7px;
    }
    .user-table th {
        background-color: white;
        color: black;
        cursor: pointer;
    }
    .user-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .user-table tr:hover {
        background-color: #f1f1f1;
    }
    .action-button {
        padding: 5px 10px;
        font-size: 12px;
        margin: 2px;
        border: none;
        cursor: pointer;
        border-radius: 3px;
    }
    .update-btn {
        background-color: #fbc02d;
        color: black;
    }
    .delete-btn {
        background-color: #d32f2f;
        color: white;
    }
</style>


<div id="user_management">
    <div class="button-container2">
        <div>
            <input type="text" id="search-bar" placeholder="Search" onkeyup="searchTable()">
        </div>
        <button class="insert-btn" onclick="openUserModal()">Add User</button>
    </div>
</div>

<!-- User Modal (Add & Update) -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeUserModal()">&times;</span>
        <h2 id="modalTitle">Add New User</h2>
        <input type="hidden" id="userIdNo">
        <input type="text" id="userId" placeholder="Enter User ID"><br><br>
        <input type="password" id="userPassword" placeholder="Enter Password"><br><br>
        <input type="text" id="userSection" placeholder="Enter Section"><br><br>
        <button class="insert-btn" onclick="saveUser()">Save</button>
    </div>
</div>

<!-- User Table -->
<table class='user-table' id='user_table'>
    <thead>
        <tr>
            <th onclick="sortTable(0, this)">ID <i class="fas fa-sort"></i></th>
            <th onclick="sortTable(1, this)">Password <i class="fas fa-sort"></i></th>
            <th onclick="sortTable(2, this)">Section <i class="fas fa-sort"></i></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['password']); ?></td>
                <td><?php echo htmlspecialchars($row['section']); ?></td>
                <td>
                    <button class="action-button update-btn" onclick="editUser(<?php echo $row['id_no']; ?>, '<?php echo htmlspecialchars($row['id']); ?>', '<?php echo htmlspecialchars($row['section']); ?>')">Update</button>
                    <button class="action-button delete-btn" onclick="deleteUser(<?php echo $row['id_no']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
function searchTable() {
    let input = document.getElementById("search-bar").value.toUpperCase();
    let table = document.getElementById("user_table");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdArray = tr[i].getElementsByTagName("td"); // Get all columns in the row
        let rowMatch = false;

        for (let j = 0; j < tdArray.length - 1; j++) { // Skip the last column (Actions)
            let td = tdArray[j];
            if (td) {
                let textValue = td.textContent || td.innerText;
                if (textValue.toUpperCase().includes(input)) {
                    rowMatch = true;
                    break; // Stop checking other columns if one matches
                }
            }
        }

        tr[i].style.display = rowMatch ? "" : "none"; // Show or hide row
    }
}

function sortTable(columnIndex, headerElement) {
    let table = document.getElementById("user_table");
    let rows = Array.from(table.getElementsByTagName("tr")).slice(1); // Skip the header row
    let currentOrder = headerElement.getAttribute("data-sort-order") || "desc"; // Default to descending
    let newOrder = currentOrder === "asc" ? "desc" : "asc"; // Toggle sorting order

    rows.sort((rowA, rowB) => {
        let cellA = rowA.getElementsByTagName("td")[columnIndex].textContent.trim().toUpperCase();
        let cellB = rowB.getElementsByTagName("td")[columnIndex].textContent.trim().toUpperCase();

        if (!isNaN(cellA) && !isNaN(cellB)) { // Numeric sorting
            return newOrder === "asc" ? cellA - cellB : cellB - cellA;
        }
        return newOrder === "asc" ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
    });

    rows.forEach(row => table.appendChild(row)); // Reorder rows in table

    // Reset all sorting icons
    document.querySelectorAll("th i").forEach(icon => {
        icon.classList.remove("fa-sort-up", "fa-sort-down");
        icon.classList.add("fa-sort");
    });

    // Update clicked column icon
    let icon = headerElement.querySelector("i");
    icon.classList.remove("fa-sort");
    icon.classList.add(newOrder === "asc" ? "fa-sort-up" : "fa-sort-down");

    // Store new sorting order
    headerElement.setAttribute("data-sort-order", newOrder);
}

function saveUser() {
    let id_no = document.getElementById("userIdNo").value;
    let id = document.getElementById("userId").value.trim();
    let password = document.getElementById("userPassword").value.trim();
    let section = document.getElementById("userSection").value.trim();

    if (id === "" || section === "") {
        alert("ID and Section are required.");
        return;
    }

    let postData = { id: id, section: section };

    // Only include password if adding a new user or updating it
    if (id_no === "" && password === "") {
        alert("Password is required for new users.");
        return;
    }
    if (password !== "") {
        postData.password = password;
    }
    
    // If ID number exists -> update, else -> insert
    let url = id_no ? 'part/update_user.php' : 'part/insert_user.php';
    if (id_no) postData.id_no = id_no;

    $.post(url, postData, function(response) {
        alert(response);
        location.reload();
    });
}

// Open modal for updating
function editUser(id_no, id, section) {
    document.getElementById("modalTitle").innerText = "Update User";
    document.getElementById("userIdNo").value = id_no;
    document.getElementById("userId").value = id;
    document.getElementById("userSection").value = section;
    document.getElementById("userPassword").value = ""; // Leave blank to not change
    document.getElementById("userModal").style.display = "block";
}

// Open modal for adding new user
function openUserModal() {
    document.getElementById("modalTitle").innerText = "Add New User";
    document.getElementById("userIdNo").value = "";
    document.getElementById("userId").value = "";
    document.getElementById("userPassword").value = "";
    document.getElementById("userSection").value = "";
    document.getElementById("userModal").style.display = "block";
}

// Delete user
function deleteUser(id_no) {
    if (confirm("Are you sure you want to delete this user?")) {
        $.post('part/delete_user.php', { id_no: id_no }, function(response) {
            alert(response);
            location.reload();
        });
    }
}
</script>

