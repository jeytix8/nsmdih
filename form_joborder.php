<?php

ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/connect.php';

date_default_timezone_set('Asia/Manila');

$departments = [];
$job_orders = [];

// Fetch departments
$dept_stmt = $conn->prepare("SELECT category FROM category_job_order WHERE type = 'Department'");
$dept_stmt->execute();
$dept_stmt->bind_result($department);
while ($dept_stmt->fetch()) {
    $departments[] = $department;
}
$dept_stmt->close();

// Fetch job orders
$job_stmt = $conn->prepare("SELECT category FROM category_job_order WHERE type = 'Job Order'");
$job_stmt->execute();
$job_stmt->bind_result($job_order);
while ($job_stmt->fetch()) {
    $job_orders[] = $job_order;
}
$job_stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $department = $_POST['department'] ?? '';
    $description = $_POST['description'] ?? '';
    $job_order_nature = $_POST['job_order_nature'] ?? '';

    if (empty($name) || empty($department) || empty($job_order_nature)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    $current_year = date("Y");
    $current_month = date("F");
    $current_day = date("d");
    $current_time = date("H:i:s");

    $satisfied_count = 0;
    $unsatisfied_count = 0;
    $total_weight = 20;

    $categories = ['time_of_response', 'time_of_resolution', 'communication_clarity', 'quality_of_support', 'professionalism'];

    foreach ($categories as $category) {
        if (isset($_POST[$category])) {
            if (strpos($_POST[$category], 'y_') === 0) {
                $satisfied_count++;
            } else {
                $unsatisfied_count++;
            }
        }
    }

    $satisfied_percentage = $satisfied_count * $total_weight;
    $unsatisfied_percentage = $unsatisfied_count * $total_weight;

    $insert_stmt = $conn->prepare("INSERT INTO records_job_order (name, department, job_order_nature, description, issue_year, issue_month, issue_day, issue_time, satisfied, unsatisfied) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("ssssssssss", $name, $department, $job_order_nature, $description, $current_year, $current_month, $current_day, $current_time, $satisfied_percentage, $unsatisfied_percentage);

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
        height: 87vh;
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
        font-size: 16px;
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
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: bold;
    }
    

    .rating-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin-bottom: 20px;
    }

    .rating-table th, .rating-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    .rating-table td{
        font-size: 12px;
    }

    .rating-table th {
        background-color: #1a0c80;
        color: white;
        font-weight: bold;
    }

    .rating-table input[type="radio"] {
        transform: scale(1.2); /* Adjust size if needed */
        margin: 0;
        vertical-align: middle;
    }


</style>

<div class="job_order" id="job_order">
    <div class="login-form">
        <h1>Job Order</h1>
        <form id="reportForm">

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <select id="department" name="department" class="form-control" required>
                        <option value="" disabled selected>Select Department</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept); ?>"><?php echo htmlspecialchars($dept); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="job_order_nature">Nature of Job Order</label>
                <select id="job_order_nature" name="job_order_nature" class="form-control" required>
                    <option value="" disabled selected>Select Nature of Job Order</option>
                    <?php foreach ($job_orders as $job_order): ?>
                        <option value="<?php echo htmlspecialchars($job_order); ?>"><?php echo htmlspecialchars($job_order); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" name="description" class="form-control" placeholder="Enter description">
            </div>

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
                        <td><input type="radio" name="time_of_response" value="y_timeofresponse" required></td>
                        <td><input type="radio" name="time_of_response" value="n_timeofresponse" required></td>
                    </tr>
                    <tr>
                        <td>Time of Resolution</td>
                        <td><input type="radio" name="time_of_resolution" value="y_timeofresolution" required></td>
                        <td><input type="radio" name="time_of_resolution" value="n_timeofresolution" required></td>
                    </tr>
                    <tr>
                        <td>Communicated Clearly</td>
                        <td><input type="radio" name="communication_clarity" value="y_communication" required></td>
                        <td><input type="radio" name="communication_clarity" value="n_communication" required></td>
                    </tr>
                    <tr>
                        <td>Quality of Support</td>
                        <td><input type="radio" name="quality_of_support" value="y_quality" required></td>
                        <td><input type="radio" name="quality_of_support" value="n_quality" required></td>
                    </tr>
                    <tr>
                        <td>Professionalism of Support Team</td>
                        <td><input type="radio" name="professionalism" value="y_professionalism" required></td>
                        <td><input type="radio" name="professionalism" value="n_professionalism" required></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" id="button">Submit</button>
        </form>
    </div>
</div>

<script>
document.getElementById('reportForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('form_joborder.php', {
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
