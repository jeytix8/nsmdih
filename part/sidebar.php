<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}
?>

   <style>

/*   	icon*/
   	.bi-clipboard-data-fill {
   		color: yellow!important;
   	}

    .menu-link:hover {
        background-color: #130863;
    }

    .menu-item .menu-title  {
        color:white!important;
    }

    #kt_app_sidebar {
        background-color: #090145;
    }

    .menu-item .menu-arrow{
        color: whitesmoke !important;
    }

    .btn-custom.btn-primary:hover {
        filter: brightness(1.5);
    }


</style>
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<!--begin::Logo-->
	<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
		<!--begin::Logo image-->
		<a href="index.php">
            <img alt="Logo" src="sinai_logo.png" class="h-70px w-180px app-sidebar-logo-default" />
            <img alt="Logo" src="sinai_logo.png" class="h-40px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
		<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
			<i class="ki-duotone ki-black-left-line fs-3 rotate-180">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		<!--end::Sidebar toggle-->
	</div>
	<!--end::Logo-->
	<!--begin::sidebar menu-->
	<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
		<!--begin::Menu wrapper--> 
		<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
			<!--begin::Scroll wrapper-->
			<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
				<!--begin::Menu-->
				<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
					<!--begin:Menu item-->
					<div class="menu-item">
						<!--begin:Menu link-->
						<a class="menu-link" href="#" onclick="showSection(event, 'dashboard');">
							<span class="menu-icon">
								<i class="bi bi-clipboard-data-fill"></i>
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
							</span>
							<span class="menu-title">Dashboard</span>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div  class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="#" onclick="showSection(event, 'request', true);">
                           <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <!-- Example SVG for a ticket-like icon -->
                                        <path opacity=0.85 d="M4 2h16c.55 0 1 .45 1 1v3c-1.1 0-2 .9-2 2s.9 2 2 2v3c-1.1 0-2 .9-2 2s.9 2 2 2v3c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1v-3c1.1 0 2-.9 2-2s-.9-2-2-2V8c1.1 0 2-.9 2-2s-.9-2-2-2V3c0-.55.45-1 1-1zm15 17.5V19h-2v.5c0 .83-.67 1.5-1.5 1.5H8.5c-.83 0-1.5-.67-1.5-1.5V19H5v.5c0 .83-.67 1.5-1.5 1.5H4v-15h15v15zm-9-9H9V6h3v4.5zm1 0V6h3v4.5h-3z"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Request Lists</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7" style="color: yellow!important;">Main</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->


                    <!--begin:Menu item-->
                    <div  class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="#" onclick="showSection(event, 'assignment', true);">
                           <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <!-- Example SVG for a ticket-like icon -->
                                        <path opacity=0.85 d="M4 2h16c.55 0 1 .45 1 1v3c-1.1 0-2 .9-2 2s.9 2 2 2v3c-1.1 0-2 .9-2 2s.9 2 2 2v3c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1v-3c1.1 0 2-.9 2-2s-.9-2-2-2V8c1.1 0 2-.9 2-2s-.9-2-2-2V3c0-.55.45-1 1-1zm15 17.5V19h-2v.5c0 .83-.67 1.5-1.5 1.5H8.5c-.83 0-1.5-.67-1.5-1.5V19H5v.5c0 .83-.67 1.5-1.5 1.5H4v-15h15v15zm-9-9H9V6h3v4.5zm1 0V6h3v4.5h-3z"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Assignment</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                    <!--begin:Menu item-->
                    <div  class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="#" onclick="showSection(event, 'records', true);">
                           <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <!-- Example SVG for a ticket-like icon -->
                                        <path opacity=0.85 d="M4 2h16c.55 0 1 .45 1 1v3c-1.1 0-2 .9-2 2s.9 2 2 2v3c-1.1 0-2 .9-2 2s.9 2 2 2v3c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1v-3c1.1 0 2-.9 2-2s-.9-2-2-2V8c1.1 0 2-.9 2-2s-.9-2-2-2V3c0-.55.45-1 1-1zm15 17.5V19h-2v.5c0 .83-.67 1.5-1.5 1.5H8.5c-.83 0-1.5-.67-1.5-1.5V19H5v.5c0 .83-.67 1.5-1.5 1.5H4v-15h15v15zm-9-9H9V6h3v4.5zm1 0V6h3v4.5h-3z"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Records</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                    <!--begin:Menu item-->
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7" style="color: yellow!important;">End-User</span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->

                    <div class="menu-item">
                        <a class="menu-link" href="#" onclick="showSection(event, 'job_order');">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                         <g id="duotune">
                                            <!-- Document background -->
                                            <path opacity="0.6" d="M4 2h12l4 4v14c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1zM16 7h4l-4-4v4z" />
                                            <!-- Plus mark for submission -->
                                            <path d="M12 9c.55 0 1 .45 1 1v2h2c.55 0 1 .45 1 1s-.45 1-1 1h-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2H9c-.55 0-1-.45-1-1s.45-1 1-1h2V10c0-.55.45-1 1-1z" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Request Form</span>
                        </a>
                    </div>
					<!--end:Menu item-->

					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7" style="color: yellow!important;">Other</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->

					<div class="menu-item">
                        <a class="menu-link" href="#" onclick="showSection(event, 'category_section');">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                        <g id="duotune">
                                            <!-- Document background -->
                                            <path opacity="0.6" d="M4 2h12l4 4v14c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1zM16 7h4l-4-4v4z" />
                                            <!-- Plus mark for submission -->
                                            <path d="M12 9c.55 0 1 .45 1 1v2h2c.55 0 1 .45 1 1s-.45 1-1 1h-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2H9c-.55 0-1-.45-1-1s.45-1 1-1h2V10c0-.55.45-1 1-1z" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Category</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link" href="#" onclick="showSection(event, 'user_account');">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                        <g id="duotune">
                                            <!-- Document background -->
                                            <path opacity="0.6" d="M4 2h12l4 4v14c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1zM16 7h4l-4-4v4z" />
                                            <!-- Plus mark for submission -->
                                            <path d="M12 9c.55 0 1 .45 1 1v2h2c.55 0 1 .45 1 1s-.45 1-1 1h-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2H9c-.55 0-1-.45-1-1s.45-1 1-1h2V10c0-.55.45-1 1-1z" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Users</span>
                        </a>
                    </div>

				</div>
				<!--end::Menu-->
			</div>
			<!--end::Scroll wrapper-->
		</div>
		<!--end::Menu wrapper-->
	</div>
	<!--end::sidebar menu-->
	<!--begin::Footer-->
	<div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
		<a href="#" 
            onclick="document.getElementById('logoutForm').submit();" 
            class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100" 
            data-bs-toggle="tooltip" 
            data-bs-trigger="hover" 
            data-bs-dismiss="click" 
            title="End Session">
            <span class="btn-label" style="color: yellow;">Logout</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="yellow">
              <path d="M10 2a1 1 0 0 0-1 1v2a1 1 0 1 0 2 0V4h6v16h-6v-1a1 1 0 1 0-2 0v2a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1h-8z"/>
              <path d="M10.707 15.707a1 1 0 0 1-1.414-1.414L11.586 12H3a1 1 0 1 1 0-2h8.586l-2.293-2.293a1 1 0 1 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4z"/>
            </svg>
        </a>
        <!-- Hidden Form -->
        <form id="logoutForm" action="part/logout.php" method="POST" style="display: none;">
            <input type="hidden" name="submit1" value="1">
        </form>
	</div>
	<!--end::Footer-->
</div>


<script>    


    function showSection(event, sectionId, analyticsPage, isLogHistory = false) {
        event.preventDefault(); // Prevent default action

        // Set the URL parameter based on the clicked section
        window.location.href = window.location.pathname + '?section=' + sectionId + '&analytics=' + analyticsPage + '&isLogHistory=' + isLogHistory;

        // Hide all sections
        var sections = document.querySelectorAll('#dashboard, #request, #assignment, #records, #student_acc, #faculty_acc, #staff_acc, #admin_acc, #job_order, #archive, #category_section');
        sections.forEach(function(section) {
            section.style.display = 'none';
        });

        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';

        // Activate the clicked menu item
        var menuLinks = document.querySelectorAll('.menu-link');
        menuLinks.forEach(function(link) {
            link.classList.remove('active');
        });
        event.target.closest('.menu-link').classList.add('active');
    }
</script>