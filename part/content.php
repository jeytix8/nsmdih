<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

$section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';  // Set default section to 'dashboard'

?>

<div class="d-flex flex-column flex-column-fluid" style="background-color: whitesmoke; height: auto;">
    <!-- Begin: Content -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!-- Begin: Content Container -->
        <div id="kt_app_content_container" class="app-container container-fluid content-area">
            <!-- Show content conditionally based on the clicked sidebar link -->
            
            <?php if ($section === 'dashboard') : ?>
                <?php include "dashboard.php"; ?>
            <?php elseif ($section === 'request') : ?>
                <?php include "content_joborder_requests.php"; ?>
            <?php elseif ($section === 'assignment') : ?>
                <?php include "content_joborder_assignment.php"; ?>
            <?php elseif ($section === 'records') : ?>
                <?php include "content_joborder_records.php"; ?>
            <?php elseif (in_array($section, ['student_acc', 'faculty_acc', 'staff_acc', 'admin_acc'])) : ?>
                <?php include "content_adminnewacc.php"; ?>
            <?php elseif ($section === 'job_order') : ?>
                <?php include "form_joborder.php"; ?>
            <?php elseif ($section === 'category_section') : ?>
                <?php include "content_category.php"; ?>
            <?php elseif ($section === 'archive') : ?>
                <?php include "unarchive_frontend.php";?>
            <?php else : ?>
                <p>Invalid section. Please select a valid section from the sidebar.</p>
            <?php endif; ?>
        </div>
        <!-- End: Content Container -->
    </div>
    <!-- End: Content -->
</div>
