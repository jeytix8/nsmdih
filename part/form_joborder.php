<?php
ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../connect.php';

date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['secured']) || !isset($_SESSION['user_section'])) {
    header('Location: login.php');
    exit();
}

$user_section = $_SESSION['user_section']; // User's section

// **Single Query to Fetch Employees (Handles Both Dropdown & Image Fetching)**
$emp_stmt = $conn->prepare("SELECT name, image_data FROM employees WHERE section = ? ORDER BY name ASC");
$emp_stmt->bind_param("s", $user_section);
$emp_stmt->execute();
$emp_stmt->bind_result($emp_name, $emp_image);

$employees = [];
while ($emp_stmt->fetch()) {
    $employees[] = [
        'name' => $emp_name,
        'image' => $emp_image ? 'data:image/jpeg;base64,' . base64_encode($emp_image) : 'placeholder.png'
    ];
}

// **Check if a specific image needs to be served**
if (isset($_GET['name'])) {
    $name = $_GET['name'];

    foreach ($employees as $emp) {
        if ($emp['name'] === $name) {
            if ($emp['image'] !== 'placeholder.png') {
                header("Content-Type: image/jpeg"); // Adjust if needed
                echo base64_decode(explode(',', $emp['image'])[1]); // Decode base64 back to binary
            } else {
                header("Content-Type: image/png");
                readfile("../placeholder.png");
            }
            exit(); // **Stop script after serving image**
        }
    }

    // If name not found, return placeholder
    header("Content-Type: image/png");
    readfile("../placeholder.png");
    exit();
}

// **Fetch job orders**
$job_orders = [];
$job_stmt = $conn->prepare("SELECT category FROM category_job_order ORDER BY category ASC");
$job_stmt->execute();
$job_stmt->bind_result($job_order);
while ($job_stmt->fetch()) {
    $job_orders[] = $job_order;
}
$job_stmt->close();


// **Handle Form Submission**
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $section = $_SESSION['user_section']; // Set from session
    $description = $_POST['description'] ?? '';
    $job_order_nature = $_POST['job_order_nature'] ?? '';

    if (empty($name) || empty($section) || empty($job_order_nature)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    $current_year = date("Y");
    $current_month = date("F");
    $current_day = date("d");
    $current_time = date("H:i:s");
    $status = "In Queue";

    $insert_stmt = $conn->prepare("INSERT INTO records_job_order (name, section, job_order_nature, description, issue_year, issue_month, issue_day, issue_time, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("sssssssss", $name, $section, $job_order_nature, $description, $current_year, $current_month, $current_day, $current_time, $status);

    if ($insert_stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error saving record: " . $conn->error]);
    }

    $insert_stmt->close();
    exit();
}

$conn->close();
ob_end_flush();
?>



<!-- HTML and CSS code remains the same as you provided -->
<style>
    /* Styling the form */
    .login-form {
        background-color: rgba(255, 255, 255, 1);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        max-width: 700px;
        width: 100%;
        z-index: 1000;
        position: absolute; 
        top: 50%; 
        left: 58%; 
        height: 380px;
        transform: translate(-50%, -50%);
    }

    h1 {
        font-family: 'Tahoma', sans-serif;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    #button {
        background-color: #1a0c80;
        font-family: 'Tahoma', sans-serif;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        color: white;
        padding: 10px;
        margin-top: 7px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 100%;
    }

    #button:hover {
        background-color: #3725b3!important;

    }

    select, input {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        border: 1px solid gray;
        border-radius: 5px;
    }

    .form-control {
        height: 35px;
        font-size: 12px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-group {
        text-align: left; 
        margin-left: 5px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: bold;
    }
    .form-group select {
        font-size: 11px;
    }
    


</style>

<div class="job_order" id="job_order">
    <div class="login-form">
        <h1>Job Order</h1>
        <form id="reportForm">

            <div class="form-row">
                <!-- Image Preview Box -->
                <img id="profileImage" src="part/form_joborder.php?name=" alt="Employee Image" style="width: 200px; height: 200px; border-radius: 10px; border: 1px solid gray; object-fit: cover;">
                

                <!-- Name Dropdown -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <select id="name" name="name" class="form-control" required>
                        <option value="" disabled selected>Select Name</option>
                        <?php foreach ($employees as $emp): ?>
                            <option value="<?php echo htmlspecialchars($emp['name']); ?>" 
                                    data-image="<?php echo htmlspecialchars($emp['image']); ?>">
                                <?php echo htmlspecialchars($emp['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                    <label for="job_order_nature">Nature of Job Order</label>
                    <select id="job_order_nature" name="job_order_nature" class="form-control" required>
                        <option value="" disabled selected>Select Nature of Job Order</option>
                        <?php foreach ($job_orders as $job_order): ?>
                            <option value="<?php echo htmlspecialchars($job_order); ?>"><?php echo htmlspecialchars($job_order); ?></option>
                        <?php endforeach; ?>
                    </select>


                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" class="form-control" placeholder="Enter description" required>
                </div>
            </div>

            <button type="submit" id="button">Submit</button>
        </form>
    </div>
</div>


<script>
document.getElementById('name').addEventListener('change', function() {
    let selectedName = this.value;
    let profileImage = document.getElementById('profileImage');

    if (selectedName) {
        profileImage.src = "part/form_joborder.php?name=" + encodeURIComponent(selectedName);
    }
});


document.getElementById('reportForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('part/form_joborder.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Report Submitted',
                text: 'Your report has been successfully submitted!',
            });
            this.reset();
            // Reset image preview to placeholder
            document.getElementById('profileImage').src = "placeholder.png"; 

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'An error occurred while submitting the report.',
            });
        }
    })
    .catch(error => {
        console.error('Error submitting form:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred.',
        });
    });
});
</script>


</body>
</html>
