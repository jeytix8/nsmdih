<?php
session_start();

// Set session timeout duration (e.g., 15 minutes)
$timeout_duration = 1200; // 20 minutes in seconds

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Last request was more than the timeout duration ago
    session_unset();
    session_destroy();
    header("Location: part/login.php?timeout=1");
    exit();
}

$_SESSION['last_activity'] = time(); // Update last activity timestamp

// Redirect to login page if user is not logged in
if (!isset($_SESSION['secured'])) {
    header("Location: part/login.php");
    exit();
}
?>


<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="<?php echo $_SERVER['REQUEST_URI']; ?>">

		<title>NSMDIH Job Order System</title>
		<script type="text/javascript" src="assets/media/jquery.js"></script>
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="sinai_logo.png" />

	
		<link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	</head>

	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">

				<!-- NAVIGATION BAR, but only show when mobile view if height is not setted-->
				<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container" style="background-color: darkblue;">
					<!--begin::Mobile Toggle-->
					<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
						<div class="btn btn-icon btn-active-color-primary w-250px h-70px" id="kt_app_sidebar_mobile_toggle">
							<i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
							<h1 style="color:yellow; margin-left: 15px; padding-top: 10px;">Job Order System</h1>
						</div>
					</div>
					<!--end::Mobile Toggle-->

					<!-- Logo -->
					<div class="d-flex align-items-center justify-content-end flex-grow-1 flex-lg-grow-0">
					    <a href="index.php" class="d-lg-none d-flex align-items-center gap-2"> 
					        <img alt="Logo" src="sinai_logo.png" class="h-30px">
					    </a>
					</div>

					<!-- Logo end-->
				</div>
				<!-- NAV BAR END -->

				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Sidebar-->
					<?php include 'part/sidebar.php'; ?>
					<!--end::Sidebar-->
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<!-- CONTENT CONTENT CONTENTTTTTTTTTTTT -->
						<?php include "part/content.php" ?>
						<!--end::Content wrapper-->
						<!--begin::Footer-->
						<!-- FOOTER FOOTER FOOTERRRRRRRRRRRRRRRRRRRR-->
						<!--end::Footer-->
					</div>
					<!--end:::Main-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->
		
		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Scrolltop-->
		
		
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>


		<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Vendors Javascript-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/widgets.bundle.js"></script>
		<script src="assets/js/custom/widgets.js"></script>
		<script src="assets/js/custom/apps/chat/chat.js"></script>
		<script src="assets/js/custom/utilities/modals/upgrade-plan.js"></script>
		<script src="assets/js/custom/utilities/modals/create-app.js"></script>
		<script src="assets/js/custom/utilities/modals/new-target.js"></script>
		<script src="assets/js/custom/utilities/modals/users-search.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->

	</body>
	<!--end::Body-->
</html>