<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php';

// Fetch employees including images
$query = "SELECT id, name, section, image_data FROM employees ORDER BY id ASC";
$result = mysqli_query($conn, $query);

// Fetch DISTINCT sections for dropdown (Add/Update Modal) from `accounts.section`
$accountSectionQuery = "SELECT DISTINCT section FROM accounts ORDER BY section ASC";
$accountSectionResult = mysqli_query($conn, $accountSectionQuery);
$accountSections = [];
while ($row = mysqli_fetch_assoc($accountSectionResult)) {
    $accountSections[] = $row['section'];
}

// Fetch DISTINCT sections for filtering from `employees.section`
$employeeSectionQuery = "SELECT DISTINCT section FROM employees ORDER BY section ASC";
$employeeSectionResult = mysqli_query($conn, $employeeSectionQuery);
$employeeSections = [];
while ($row = mysqli_fetch_assoc($employeeSectionResult)) {
    $employeeSections[] = $row['section'];
}
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
    #search-bar {
        width: 100%;
        max-width: 300px;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .employee-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 13px;
        text-align: center;
    }
    .employee-table th, .employee-table td {
        border: 1px solid #ddd;
        padding: 7px;
    }
    .employee-table th {
        background-color: white;
        color: black;
        cursor: pointer;
    }
    .employee-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .employee-table tr:hover {
        background-color: #f1f1f1;
    }
    .button-container2 {
        display: flex;
        justify-content: space-between;
        margin: 20px;
    }

    /* Left side (Search & Filter) */
    .left-controls {
        display: flex;
        align-items: center;
        gap: 5px; /* Space between search and filter */
    }

    /* Search Bar */
    #search-bar {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Filter Button (White Background) */
    .filter-button {
        background-color: white;
        border: 1px solid #ccc;
        padding: 12px 12px;
        cursor: pointer;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Filter Box (Hidden by Default) */
    .filter-container {
        position: relative;
    }

    .filter-box {
        display: none;
        position: absolute;
        left: 0px;
        top: 38px;
        background: white;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
        z-index: 1000;
        white-space: nowrap;
        width: auto; /* Adjust width as needed */
    }

    .filter-options {
        column-count: 2; /* Create two vertical columns */
        column-gap: 40px; /* Adjust spacing between columns */
    }

    .filter-options label {
        display: block; /* Ensures each checkbox is on a new line */
        white-space: nowrap; /* Prevents text wrapping */
        margin-top: 2px;
        font-size: 11px;
    }

    /* Show filter options when hovering over the filter button */
    .filter-container:hover .filter-box {
        display: block;
    }

    /* Right Side (Add Employee Button) */
    .insert-btn {
        background-color: #388e3c;
        color: white;
        padding: 10px 15px;
        font-size: 14px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
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

    /* Rounded Square Upload Box */
    .upload-label {
        display: block;
        width: 150px;
        height: 150px;
        border-radius: 15px;
        border: 2px dashed #aaa;
        text-align: center;
        cursor: pointer;
        overflow: hidden;
    }

    .image-container {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #666;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
    }

    .modal { display: none; /* Hide by default */ }
</style>

<div id="employee_management">
    <div class="button-container2">
        
        <!-- Left Side (Search & Filter) -->
        <div class="left-controls">
            <input type="text" id="search-bar" placeholder="Search" onkeyup="filterEmployees()">

            <!-- Filter Button (White Background) -->
            <div class="filter-container">
                <button class="filter-button">
                    <i style="color: black;" class="bi bi-funnel-fill"></i>
                </button>

                <!-- Filter Box (Hidden by Default, Shows on Hover) -->
            <div class="filter-box">
                <label><strong>Filter by Section:</strong></label>
                <div class="filter-options">
                    <?php foreach ($employeeSections as $section) { ?>
                        <label>
                            <input type="checkbox" class="section-filter" value="<?php echo htmlspecialchars(strtoupper($section)); ?>" onclick="filterEmployees()">
                            <?php echo htmlspecialchars($section); ?>
                        </label>
                    <?php } ?>
                </div>
            </div>

            </div>
        </div>

        <!-- Right Side (Add Employee Button) -->
        <button class="insert-btn" onclick="openEmployeeModal()">Add Employee</button>

    </div>
</div>


<!-- Employee Modal (Add & Update) -->
<div id="employeeModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEmployeeModal()">&times;</span>
        <h2 id="modalTitle">Add New Employee</h2>
        <input type="hidden" id="employeeId">
        <input type="text" id="employeeName" placeholder="Enter Employee Name"><br><br>
        
        <!-- Section Dropdown (From `accounts.section`) -->
        <select id="employeeSection">
            <option value="">Select Section</option>
            <?php foreach ($accountSections as $section) { ?>
                <option value="<?php echo htmlspecialchars($section); ?>"><?php echo htmlspecialchars($section); ?></option>
            <?php } ?>
        </select>
        <br><br>

        <!-- Image Upload (Styled as Rounded Square) -->
        <input type="file" id="employeeImage" accept="image/*" style="display: none;">
        <label for="employeeImage" class="upload-label">
            <div id="imagePreview" class="image-container">
                <span>Click to Upload</span>
            </div>
        </label>

        <button class="insert-btn" onclick="saveEmployee()">Save</button>
    </div>
</div>


<!-- Croppie Modal (For Cropping & Adjusting Image) -->
<div id="cropModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeCropModal()">&times;</span>
        <h2>Adjust Your Image</h2>
        <div id="croppieContainer"></div>  <!-- Croppie.js Container -->
        <button class="insert-btn" onclick="cropAndSave()">Save Image</button>
    </div>
</div>


<!-- Employee Table -->
<table class='employee-table' id='employee_table'>
    <thead>
        <tr>
            <th onclick="sortTable(0, this)">ID <i class="fas fa-sort"></i></th>
            <th>Image</th>
            <th onclick="sortTable(2, this)">Name <i class="fas fa-sort"></i></th>
            <th onclick="sortTable(3, this)">Section <i class="fas fa-sort"></i></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { 
            // Convert BLOB image to Base64 (if exists)
            $imageSrc = (!empty($row['image_data'])) ? 'data:image/jpeg;base64,' . base64_encode($row['image_data']) : 'placeholder.png';
        ?>
            <tr>
                <td><?php echo $row['id']; ?></td> <!-- ID Column -->
                <td><img src="<?php echo $imageSrc; ?>" alt="Employee Image" style="width: 45px; height: 45px; border-radius: 5px; object-fit: cover;"></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['section']); ?></td>
                <td>
                    <button class="action-button update-btn" onclick="editEmployee(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['name']); ?>', '<?php echo htmlspecialchars($row['section']); ?>')">Update</button>
                    <button class="action-button delete-btn" onclick="deleteEmployee(<?php echo $row['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<script>
function searchTable() {
    let input = document.getElementById("search-bar").value.toUpperCase();
    let table = document.getElementById("employee_table");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            let textValue = td.textContent || td.innerText;
            tr[i].style.display = textValue.toUpperCase().includes(input) ? "" : "none";
        }
    }
}

function sortTable(columnIndex, headerElement) {
    let table = document.getElementById("employee_table");
    let rows = Array.from(table.getElementsByTagName("tr")).slice(1);
    let order = headerElement.getAttribute("data-sort-order") === "asc" ? "desc" : "asc";

    rows.sort((a, b) => {
        let cellA = a.cells[columnIndex];
        let cellB = b.cells[columnIndex];

        // Skip sorting for the Image column (Index 1)
        if (columnIndex === 1) return 0;

        let textA = cellA.innerText || cellA.textContent;
        let textB = cellB.innerText || cellB.textContent;

        // If sorting ID column (numeric sorting)
        if (columnIndex === 0) {
            return order === "asc" ? textA - textB : textB - textA;
        }

        // Otherwise, sort alphabetically
        return order === "asc" ? textA.localeCompare(textB) : textB.localeCompare(textA);
    });

    rows.forEach(row => table.appendChild(row));
    headerElement.setAttribute("data-sort-order", order);
}


function filterEmployees() {
    let searchValue = document.getElementById("search-bar").value.toUpperCase();
    let selectedSections = Array.from(document.querySelectorAll(".section-filter:checked"))
        .map(checkbox => checkbox.value.toUpperCase());

    let table = document.getElementById("employee_table");
    let rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let idCell = rows[i].getElementsByTagName("td")[0].innerText.toUpperCase();
        let nameCell = rows[i].getElementsByTagName("td")[2].innerText.toUpperCase();
        let sectionCell = rows[i].getElementsByTagName("td")[3].innerText.toUpperCase();

        let matchesSearch = idCell.includes(searchValue) || nameCell.includes(searchValue);
        let matchesFilter = selectedSections.length === 0 || selectedSections.includes(sectionCell);

        rows[i].style.display = matchesSearch && matchesFilter ? "" : "none";
    }
}


function openEmployeeModal() {
    document.getElementById("modalTitle").innerText = "Add New Employee";
    document.getElementById("employeeId").value = "";
    document.getElementById("employeeName").value = "";
    document.getElementById("employeeSection").value = "";
    document.getElementById("employeeModal").style.display = "block";
}

function editEmployee(id, name, section) {
    document.getElementById("modalTitle").innerText = "Update Employee";
    document.getElementById("employeeId").value = id;
    document.getElementById("employeeName").value = name;
    document.getElementById("employeeSection").value = section;
    document.getElementById("employeeModal").style.display = "block";
}

function closeEmployeeModal() {
    document.getElementById("employeeModal").style.display = "none";
}
function saveEmployee() {
    let id = document.getElementById("employeeId").value;
    let name = document.getElementById("employeeName").value.trim();
    let section = document.getElementById("employeeSection").value.trim();
    let image = document.getElementById("employeeImage").file; // Get Cropped Image

    if (name === "" || section === "") {
        alert("Name and Section are required.");
        return;
    }

    let formData = new FormData();
    formData.append("name", name);
    formData.append("section", section);
    if (image) formData.append("image", image);

    let url = id ? 'part/update_employee.php' : 'part/insert_employee.php';
    if (id) formData.append("id", id);

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error("Error:", error));
}


function deleteEmployee(id) {
    if (confirm("Are you sure you want to delete this employee?")) {
        $.post('part/delete_employee.php', { id: id }, function(response) {
            alert(response);
            location.reload();
        });
    }
}

    let croppieInstance;

    // Open File Picker When Clicked
    document.getElementById("employeeImage").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                openCropModal(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Open Croppie Modal
    function openCropModal(imageSrc) {
        let cropModal = document.getElementById("cropModal");
        cropModal.style.display = "block";

        // Initialize Croppie
        if (croppieInstance) {
            croppieInstance.destroy(); // Destroy previous instance
        }
        croppieInstance = new Croppie(document.getElementById("croppieContainer"), {
            viewport: { width: 150, height: 150, type: "square" }, // Crop area
            boundary: { width: 200, height: 200 },
            enableExif: true
        });

        croppieInstance.bind({ url: imageSrc });
    }

    // Crop & Save Image
    function cropAndSave() {
        croppieInstance.result({ type: "blob", size: { width: 300, height: 300 }, quality: 0.8 }).then(function(blob) {
            let imageURL = URL.createObjectURL(blob);
            document.getElementById("imagePreview").innerHTML = `<img src="${imageURL}">`; // Show preview

            // Store in FormData
            let imageInput = new File([blob], "cropped_image.jpg", { type: "image/jpeg" });
            document.getElementById("employeeImage").file = imageInput;

            closeCropModal();
        });
    }

    // Close Crop Modal
    function closeCropModal() {
        document.getElementById("cropModal").style.display = "none";
    }
</script>
