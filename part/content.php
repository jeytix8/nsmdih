<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}
$user_id = isset($_SESSION['secured']) ? $_SESSION['secured'] : ''; 
$user_section = isset($_SESSION['user_section']) ? $_SESSION['user_section'] : ''; 

$default_section_tab = '';
if ($user_section == 'IT & Communication') {
    if ($user_id == 'superadmin') {
        $default_section_tab = 'dashboard';
    }
    else{
        $default_section_tab = 'assignment';
    }
}
else{
    $default_section_tab = 'job_order';
}
$section = isset($_GET['section']) ? $_GET['section'] : $default_section_tab;  // Set default section to 'dashboard'

?>

<div class="d-flex flex-column flex-column-fluid" style="background-color: whitesmoke; height: auto;">
    <!-- Begin: Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!-- Begin: Content Container -->
        <div id="kt_app_content_container" class="app-container container-fluid content-area">
            <!-- Show content conditionally based on the clicked sidebar link -->
            <?php 
                if ($user_section == 'IT & Communication') {
                    if ($user_id == 'superadmin') {
                        if ($section == 'dashboard') {
                            include 'analytics.php';
                        }
                        else if ($section == 'request') {
                            include "content_joborder_requests.php";
                        }
                    }

                    if ($section == 'assignment') {
                        include "content_joborder_assignment.php";
                    }
                    elseif ($section == 'records') {
                        include "content_joborder_records.php";
                    }
                    elseif ($section == 'category_section') {
                        include "content_category.php";
                    }
                    elseif ($section == 'user_account') {
                        include "content_user.php";
                    }
                    elseif ($section == 'employee_section') {
                        include "content_employee.php";
                    }
                    else{
                        echo "<p>Invalid section. Please select a valid section from the sidebar.</p>";
                    }
                } 
                else {
                    if ($section == 'job_order') {
                        include "form_joborder.php";
                    }
                    elseif ($section == 'job_order_status') {
                        include "status_joborder.php";
                    }
                    else{
                        echo "<p>Invalid section. Please select a valid section from the sidebar.</p>";
                    }
                }
            ?>
        </div>
        <!-- End: Content Container -->
    </div>
    <!-- End: Content -->
</div>
