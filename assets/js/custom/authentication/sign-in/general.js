"use strict";

// Class definition
var KTSigninGeneral = function() {
    // Elements
    var form;
    var submitButton;
    var validator;

    // Handle form
    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
			form,
			{
				fields: {					
					'email': {
                        validators: {
							notEmpty: {
								message: 'Email address is required'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    } 
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
				}
			}
		);		

        // Handle form submit
        submitButton.addEventListener('click', function (e) {
            // Prevent button default action
            e.preventDefault();

            // Validate form
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;
                    

                    // Simulate ajax request
                    setTimeout(function() {
                        // Hide loading indication
                        submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        submitButton.disabled = false;

                        // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        // Swal.fire({
                        //     text: "You have successfully logged in!",
                        //     icon: "success",
                        //     buttonsStyling: false,
                        //     confirmButtonText: "Ok, got it!",
                        //     customClass: {
                        //         confirmButton: "btn btn-primary"
                        //     }
                        // }).then(function (result) {
                        //     if (result.isConfirmed) { 
                        //         form.querySelector('[name="email"]').value= "";
                        //         form.querySelector('[name="password"]').value= "";  
                                                              
                        //         //form.submit(); // submit form
                        //         var redirectUrl = form.getAttribute('data-kt-redirect-url');
                        //         if (redirectUrl) {
                        //             location.href = redirectUrl;
                        //         }
                        //     }
                        // });
                        var email = form.querySelector('[name="email"]').value;
                        var pass = form.querySelector('[name="password"]').value;


                         $.ajax({
                            type: "POST",
                            url: "function/index.php",
                            data: {email:email,pass:pass}, // serializes the form's elements.
                            success: function(data)
                            {
                              if(data=='1'){
                                Swal.fire({
                                    text: "You have successfully logged in!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) { 
                                        // form.querySelector('[name="email"]').value= "";
                                        // form.querySelector('[name="password"]').value= "";  
                                                                      
                                        //form.submit(); // submit form
                                        // var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                        // if (redirectUrl) {
                                        //     location.href = redirectUrl;
                                        // }
                                        location.href="admin/index.php";
                                    }
                                });

                              }else if(data=="2"){
                                Swal.fire({
                                    text: "No account found",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                })
                              }else if(data=="0"){
                                Swal.fire({
                                    text: "Wrong Password",
                                    icon: "warning",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                })
                              }
                            }
                        });

                    }, 2000);   						
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
		});
    }

    // Public functions
    return {
        // Initialization
        init: function() {
            form = document.querySelector('#kt_sign_in_form');
            submitButton = document.querySelector('#kt_sign_in_submit');
            
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTSigninGeneral.init();
});
