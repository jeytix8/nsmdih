<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php'; // Adjust based on your actual connection file

$query = "SELECT id, category, type FROM category_job_order ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Job Order</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

        /* Ensure the modal covers the full screen */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000; /* Ensure it appears on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Style the modal content */
        .modal-content {
            background-color: white;
            padding: 20px;
            width: 40%;
            margin: 10% auto;
            text-align: center;
            border-radius: 5px;
            position: relative;
        }

        /* Close button styling */
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
</head>
<body>

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
        <input type="text" id="newCategoryType" placeholder="Enter category type">
        <br><br>
        <button class="insert-btn" onclick="insertCategory()">Insert</button>
    </div>
</div>


<table class='content-category-table' id='content_category_table'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Type</th> <!-- New Column -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td>
                    <button class="action-button update-btn" onclick="updateCategory(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['category']); ?>', '<?php echo htmlspecialchars($row['type']); ?>')">Update</button>
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
        let categoryType = document.getElementById("newCategoryType").value.trim();

        if (categoryName === "" || categoryType === "") {
            alert("Please enter both category name and type.");
            return;
        }

        $.post('part/insert_category.php', { category: categoryName, type: categoryType }, function(response) {
            alert(response);
            location.reload();
        });
    }

    function updateCategory(id, oldCategory, oldType) {
        let newCategory = prompt("Enter new category name:", oldCategory);
        let newType = prompt("Enter new category type:", oldType);

        if (newCategory && newType) {
            $.post('part/update_category.php', { id: id, category: newCategory, type: newType }, function(response) {
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

</body>
</html>
