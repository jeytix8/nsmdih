<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php'; // Adjust based on your actual connection file

$query = "SELECT id, category FROM category_job_order ORDER BY category ASC";
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
        margin: 20px;
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

    .content-category-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 13px;
        text-align: center;
    }
    .content-category-table th, .content-category-table td {
        border: 1px solid #ddd;
        padding: 7px;
    }
    .content-category-table th {
        background-color: white;
        color: black;
        cursor: pointer;
    }
    .content-category-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .content-category-table tr:hover {
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

<div id="content_category">
    <div class="button-container2">
        <div>
            <input type="text" id="search-bar" placeholder="Search" onkeyup="searchTable()">
        </div>
        <button class="insert-btn" onclick="openInsertModal()">Add Category</button>
    </div>
</div>

<!-- Insert Modal -->
<div id="insertModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeInsertModal()">&times;</span>
        <h2>Add New Category</h2>
        <input type="text" id="newCategoryName" placeholder="Enter category name">
        <br><br>
        <button class="insert-btn" onclick="insertCategory()">Insert</button>
    </div>
</div>

<!-- Category Table -->
<table class='content-category-table' id='content_category_table'>
    <thead>
        <tr>
            <th hidden>ID</th> <!-- Keep ID hidden -->
            <th onclick="sortTableCategory()">Category <i class="fas fa-sort"></i></th>
            <th>Actions</th> <!-- No sorting for actions -->
        </tr>
    </thead>

    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td hidden><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td>
                    <button class="action-button update-btn" onclick="updateCategory(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['category']); ?>')">Update</button>
                    <button class="action-button delete-btn" onclick="deleteCategory(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function searchTable() {
        let input = document.getElementById("search-bar").value.toUpperCase();
        let table = document.getElementById("content_category_table");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                let textValue = td.textContent || td.innerText;
                tr[i].style.display = textValue.toUpperCase().includes(input) ? "" : "none";
            }
        }
    }

    function sortTableCategory() {
        let table = document.getElementById("content_category_table");
        let rows = Array.from(table.getElementsByTagName("tbody")[0].rows);
        let icon = document.querySelector("th[onclick='sortTableCategory()'] i");

        // Get current sorting order (default to ASC if not set)
        let currentOrder = table.dataset.order || "ASC";
        let newOrder = currentOrder === "ASC" ? "DESC" : "ASC";
        table.dataset.order = newOrder;

        // Sort rows based on category column (index 1)
        rows.sort((rowA, rowB) => {
            let cellA = rowA.cells[1].textContent.trim().toLowerCase();
            let cellB = rowB.cells[1].textContent.trim().toLowerCase();

            if (newOrder === "ASC") return cellA.localeCompare(cellB);
            return cellB.localeCompare(cellA);
        });

        // Append sorted rows back to the table
        let tbody = table.getElementsByTagName("tbody")[0];
        tbody.innerHTML = ""; // Clear existing rows
        rows.forEach(row => tbody.appendChild(row));

        // Update sorting icon
        document.querySelectorAll("th i").forEach(i => i.className = "fas fa-sort"); // Reset all icons
        icon.className = newOrder === "ASC" ? "fas fa-sort-up" : "fas fa-sort-down"; // Set correct icon
    }

    function openInsertModal() {
        let modal = document.getElementById("insertModal");
        modal.style.display = "block";
    }

    function closeInsertModal() {
        let modal = document.getElementById("insertModal");
        modal.style.display = "none";
    }

    // Close modal if the user clicks outside the modal content
    window.onclick = function(event) {
        let modal = document.getElementById("insertModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }

    function insertCategory() {
        let categoryName = document.getElementById("newCategoryName").value.trim();

        if (categoryName === "") {
            alert("Please enter a category name.");
            return;
        }

        $.post('part/insert_category.php', { category: categoryName }, function(response) {
            alert(response);
            location.reload();
        });
    }

    function updateCategory(id, oldCategory) {
        let newCategory = prompt("Enter new category name:", oldCategory);

        if (newCategory) {
            $.post('part/update_category.php', { id: id, category: newCategory }, function(response) {
                alert(response);
                location.reload();
            });
        }
    }

    function deleteCategory(id) {
        if (confirm("Are you sure you want to delete this category?")) {
            $.post('part/delete_category.php', { id: id }, function(response) {
                alert(response);
                location.reload();
            });
        }
    }
</script>