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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
        height: 56vh;
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
        <h1>Satisfaction Survey</h1>
        <form id="reportForm">
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
