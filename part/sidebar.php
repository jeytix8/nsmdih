<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}
$secured = isset($_SESSION['secured']) ? $_SESSION['secured'] : '';
$section = isset($_SESSION['user_section']) ? $_SESSION['user_section'] : '';
$currentSection = isset($_GET['section']) ? $_GET['section'] : 'dashboard'; // Default to 'dashboard'
?>

   <style>

/*   	icon*/
   	.bi-clipboard-data-fill {
   		color: yellow!important;
   	}

    .menu-link:hover {
        background-color: #130863;
    }
    .menu-link.active {
        background-color: #130863 !important;
        color: white !important;
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

/*    Hide and show*/
    .sidebar-menu-hidden {
        display: none;
    }
    .sidebar-menu-visible {
        display: block; /* Show menu when the role is matched */
    }

</style>
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<!--begin::Logo-->
	<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
		<!--begin::Logo image-->
		<a href="index.php">
            <img alt="Logo" src="sinai_logo_main.png" class="h-70px w-180px app-sidebar-logo-default" />
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
					<div class="menu-item 
                        <?php 
                            if ($secured == 'superadmin') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
						<!--begin:Menu link-->
						<a class="menu-link <?= ($currentSection == 'dashboard') ? 'active' : ''; ?>" href="?section=dashboard">
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
                    <div class="menu-item 
                        <?php 
                            if ($secured == 'superadmin') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <!--begin:Menu link-->
                        <a class="menu-link <?= ($currentSection == 'request') ? 'active' : ''; ?>" href="?section=request">
                           <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="yellow">
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
					<div class="menu-item pt-5
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7" style="color: yellow!important;">Main</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->


                    <!--begin:Menu item-->
                    <div class="menu-item 
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <!--begin:Menu link-->
                        <a class="menu-link <?= ($currentSection == 'assignment') ? 'active' : ''; ?>" href="?section=assignment">
                           <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="yellow" width="800px" height="800px" viewBox="0 0 24 24" id="chat-alert-left" data-name="Flat Color" class="icon flat-color">
                                        <path opacity=0.45 id="primary" d="M4.09,16.51A8.41,8.41,0,0,1,2,11C2,6,6.49,2,12,2s10,4,10,9-4.49,9-10,9h0A10.81,10.81,0,0,1,9,19.59l-4.59,2.3A1,1,0,0,1,4,22a1,1,0,0,1-.62-.22,1,1,0,0,1-.35-1Z"/>
                                        <path id="secondary" d="M13.5,14.5A1.5,1.5,0,1,1,12,13,1.5,1.5,0,0,1,13.5,14.5ZM13,10V7a1,1,0,0,0-2,0v3a1,1,0,0,0,2,0Z"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Assignment</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                    <!--begin:Menu item-->
                    <div class="menu-item 
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <!--begin:Menu link-->
                        <a class="menu-link <?= ($currentSection == 'records') ? 'active' : ''; ?>" href="?section=records">
                           <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="800px" height="800px" viewBox="0 0 91 91" enable-background="new 0 0 91 91" id="Layer_1" version="1.1" xml:space="preserve" fill="yellow">
                                        <path opacity=0.55 d="M88.587,25.783L46.581,5.826c-0.672-0.317-1.45-0.317-2.12,0L2.462,25.783    c-0.861,0.408-1.41,1.277-1.41,2.232c0,0.951,0.549,1.819,1.41,2.229l41.999,19.954c0.335,0.158,0.697,0.239,1.059,0.239    c0.363,0,0.726-0.081,1.061-0.239l42.006-19.954c0.861-0.41,1.41-1.278,1.41-2.229C89.997,27.06,89.448,26.191,88.587,25.783z" />
                                        <path d="M45.521,68.085c-0.483,0-0.965-0.105-1.414-0.317L2.109,47.813c-1.643-0.781-2.341-2.744-1.562-4.386    c0.78-1.642,2.742-2.341,4.388-1.562l40.584,19.283l40.595-19.283c1.639-0.78,3.606-0.083,4.386,1.562    c0.78,1.643,0.083,3.605-1.562,4.386L46.934,67.768C46.487,67.979,46.004,68.085,45.521,68.085z" />
                                        <path d="M45.521,84.912c-0.483,0-0.965-0.105-1.414-0.317L2.109,64.641c-1.643-0.78-2.341-2.746-1.562-4.389    c0.78-1.645,2.742-2.342,4.388-1.562l40.584,19.282L86.115,58.69c1.642-0.78,3.606-0.083,4.386,1.562    c0.78,1.643,0.083,3.608-1.56,4.389L46.934,84.595C46.487,84.807,46.004,84.912,45.521,84.912z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Records</span>
                        </a>
                        <!--end:Menu link-->
                    </div>

                    <!--begin:Menu item-->
                    <div class="menu-item pt-5
                        <?php 
                            if ($section != 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7" style="color: yellow!important;"><?php echo $section; ?></span>
                        </div>
                        <!--end:Menu content-->
                    </div>
                    <!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div class="menu-item 
                        <?php 
                            if ($section != 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <a class="menu-link <?= ($currentSection == 'job_order') ? 'active' : ''; ?>" href="?section=job_order">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 48 48" fill="yellow">
                                        <path opacity=0.6 d="M14.5 19.5C13.3954 19.5 12.5 20.3954 12.5 21.5C12.5 22.6046 13.3954 23.5 14.5 23.5C15.6046 23.5 16.5 22.6046 16.5 21.5C16.5 20.3954 15.6046 19.5 14.5 19.5Z" />
                                        <path opacity=0.6 d="M12.5 33.5C12.5 32.3954 13.3954 31.5 14.5 31.5C15.6046 31.5 16.5 32.3954 16.5 33.5C16.5 34.6046 15.6046 35.5 14.5 35.5C13.3954 35.5 12.5 34.6046 12.5 33.5Z" />
                                        <path opacity=0.9 d="M11.25 6C8.3505 6 6 8.35051 6 11.25V36.75C6 39.6495 8.35051 42 11.25 42H24.0436C22.75 39.9794 22 37.5773 22 35C22 27.8203 27.8203 22 35 22C37.5773 22 39.9794 22.75 42 24.0436V11.25C42 8.3505 39.6495 6 36.75 6H11.25ZM10 21.5C10 19.0147 12.0147 17 14.5 17C16.9853 17 19 19.0147 19 21.5C19 23.9853 16.9853 26 14.5 26C12.0147 26 10 23.9853 10 21.5ZM14.5 29C16.9853 29 19 31.0147 19 33.5C19 35.9853 16.9853 38 14.5 38C12.0147 38 10 35.9853 10 33.5C10 31.0147 12.0147 29 14.5 29ZM21 19.75C21 19.0596 21.5596 18.5 22.25 18.5H36.7488C37.4391 18.5 37.9988 19.0596 37.9988 19.75C37.9988 20.4404 37.4391 21 36.7488 21H22.25C21.5596 21 21 20.4404 21 19.75ZM11.2632 11.0952H36.7298C37.4202 11.0952 37.9798 11.6549 37.9798 12.3452C37.9798 13.0356 37.4202 13.5952 36.7298 13.5952H11.2632C10.5728 13.5952 10.0132 13.0356 10.0132 12.3452C10.0132 11.6549 10.5728 11.0952 11.2632 11.0952Z" />
                                        <path opacity=0.75 d="M46 35C46 41.0751 41.0751 46 35 46C28.9249 46 24 41.0751 24 35C24 28.9249 28.9249 24 35 24C41.0751 24 46 28.9249 46 35ZM36 28C36 27.4477 35.5523 27 35 27C34.4477 27 34 27.4477 34 28V34H28C27.4477 34 27 34.4477 27 35C27 35.5523 27.4477 36 28 36H34V42C34 42.5523 34.4477 43 35 43C35.5523 43 36 42.5523 36 42V36H42C42.5523 36 43 35.5523 43 35C43 34.4477 42.5523 34 42 34H36V28Z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Request Form</span>
                        </a>
                    </div>
					<!--end:Menu item-->

                    <!--begin:Menu item-->
                    <div class="menu-item 
                        <?php 
                            if ($section != 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <a class="menu-link <?= ($currentSection == 'job_order_status') ? 'active' : ''; ?>" href="?section=job_order_status">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="yellow" width="800px" height="800px" viewBox="0 0 24 24">
                                        <path opacity=0.83 d="M5,22H19a1,1,0,0,0,1-1V6.414a1,1,0,0,0-.293-.707L16.293,2.293A1,1,0,0,0,15.586,2H5A1,1,0,0,0,4,3V21A1,1,0,0,0,5,22ZM11,6a1,1,0,0,1,2,0v6a1,1,0,0,1-2,0Zm0,10a1,1,0,0,1,2,0v1a1,1,0,0,1-2,0Z"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Job Order Status</span>
                        </a>
                    </div>
                    <!--end:Menu item-->

					<!--begin:Menu item-->
					<div class="menu-item pt-5
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7" style="color: yellow!important;">Other</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->

					<div class="menu-item 
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <a class="menu-link <?= ($currentSection == 'category_section') ? 'active' : ''; ?>" href="?section=category_section">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2" style="color: yellow;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                        <g id="duotune">
                                            <!-- Document background -->
                                            <path opacity="0.45" d="M4 2h12l4 4v14c0 .55-.45 1-1 1H4c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1zM16 7h4l-4-4v4z" />
                                            <!-- Plus mark for submission -->
                                            <path d="M12 9c.55 0 1 .45 1 1v2h2c.55 0 1 .45 1 1s-.45 1-1 1h-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2H9c-.55 0-1-.45-1-1s.45-1 1-1h2V10c0-.55.45-1 1-1z" />
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Category</span>
                        </a>
                    </div>

                    <div class="menu-item 
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <a class="menu-link <?= ($currentSection == 'employee_section') ? 'active' : ''; ?>" href="?section=employee_section">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 16 16" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(0.000000, 3.000000)" fill="yellow"> <!-- Metronic-style yellow -->
                                                <path d="M9.855,7.053 C9.432,7.624 8.021,7.772 8.021,7.772 C8.021,7.772 6.58,7.63 6.156,7.066 C4.121,7.066 3.058,9.989 3.058,9.989 L12.984,9.989 C12.984,9.988 12.146,7.053 9.855,7.053 L9.855,7.053 Z"></path>
                                                <path opacity=0.6 d="M9.943,2.918 C9.943,3.977 9.062,6 7.978,6 C6.89,6 6.011,3.977 6.011,2.918 C6.011,1.859 6.89,1 7.978,1 C9.062,1 9.943,1.859 9.943,2.918 L9.943,2.918 Z"></path>
                                                <path d="M14.104,5.021 C13.733,5.596 12.577,5.902 12.577,5.902 C12.577,5.902 11.222,5.601 10.848,5.035 C10.848,5.035 10.836,5.699 10.271,6.471 C12.071,6.239 12.849,7.974 12.849,7.974 L15.98,7.98 C15.979,7.979 16.119,5.021 14.104,5.021 L14.104,5.021 Z"></path>
                                                <path opacity=0.6 d="M13.99,1.533 C13.99,2.381 13.328,3.998 12.511,3.998 C11.691,3.998 11.03,2.381 11.03,1.533 C11.03,0.687 11.693,0 12.511,0 C13.328,0 13.99,0.688 13.99,1.533 L13.99,1.533 Z"></path>
                                                <path d="M1.918,5.021 C2.296,5.592 3.467,5.896 3.467,5.896 C3.467,5.896 4.84,5.597 5.215,5.035 C5.215,5.035 5.229,5.695 5.801,6.461 C3.977,6.231 3.191,7.953 3.191,7.953 L0.021,7.958 C0.021,7.958 -0.122,5.021 1.918,5.021 L1.918,5.021 Z"></path>
                                                <path opacity=0.6 d="M2.002,1.566 C2.002,2.394 2.666,3.977 3.481,3.977 C4.3,3.977 4.961,2.394 4.961,1.566 C4.961,0.737 4.299,0.065 3.481,0.065 C2.664,0.065 2.002,0.737 2.002,1.566 L2.002,1.566 Z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title" style="color:white">Employees</span>
                        </a>
                    </div>

                    <div class="menu-item 
                        <?php 
                            if ($section == 'IT & Communication') {
                                echo 'sidebar-menu-visible'; // Show the menu when conditions are met
                            } else {
                                echo 'sidebar-menu-hidden'; // Keep it hidden by default
                            }
                        ?>
                    " >
                        <a class="menu-link <?= ($currentSection == 'user_account') ? 'active' : ''; ?>" href="?section=user_account">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1">
                                        <defs><style>.cls-1{fill:yellow;stroke:#020202;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs>
                                        <circle opacity=0.6 class="cls-1" cx="12.02" cy="7.24" r="5.74"/>
                                        <path opacity=0.6 class="cls-1" d="M2.46,23.5V21.59a9.55,9.55,0,0,1,7-9.21"/>
                                        <path class="cls-1" d="M16.8,14.89l-1,1.91H9.15L7.24,18.72l1.91,1.91h6.7l1,1.91h2.87a2.86,2.86,0,0,0,2.87-2.87V17.76a2.87,2.87,0,0,0-2.87-2.87Z"/>
                                        <line class="cls-1" x1="12.02" y1="18.72" x2="12.02" y2="20.63"/><line class="cls-1" x1="19.67" y1="17.76" x2="19.67" y2="19.67"/>
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
    function showSection(event, sectionId) {
        event.preventDefault(); 

        // Update the URL
        history.pushState(null, null, '?section=' + sectionId);

        // Remove 'active' class from all links
        document.querySelectorAll('.menu-link').forEach(link => {
            link.classList.remove('active');
        });

        // Add 'active' class to clicked link
        event.currentTarget.classList.add('active');

        // Hide all sections
        document.querySelectorAll('.section').forEach(section => {
            section.style.display = 'none';
        });

        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';
    }

</script>