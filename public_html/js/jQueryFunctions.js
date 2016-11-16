/* TODO: CHANGE TO USE PLUGIN */
/* Script used to validate food form */
$(document).ready(function() {
	$("#food-submit").click(function(event) {
		var item1 = $("#item1").val();
		var item2 = $("#item2").val();
		var isNum = /[0-9]+/; // test if user entered any numbers => invalid input

		$("#foodFormError0").removeClass("show-form-error").addClass("form-error");
		$("#foodFormError1").removeClass("show-form-error").addClass("form-error");

		if (item1 == null || item1 == "" || item2 == null || item2 == "" ||
			isNum.test(item1) || isNum.test(item2)) {
			$("#foodFormError0").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		} else if (item1 == item2) {
			$("#foodFormError1").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		}
	});
});

/* TODO: CHANGE TO USE PLUGIN */
/* Script used to validate contact form */
$(document).ready(function() {
	$("#contact-submit").click(function(event) {
		var name = $("#form_name").val();
		var surname = $("#form_lastname").val();
		var email = $("#form_email").val();
		var message = $("#form_message").val();
		var regex_name = /[a-zA-Z]+/;
		var regex_lastname = /[a-zA-Z]+/;
		var regex_email = /[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]+/;
		var regex_message = /\w+/;

		$("#contactFormError0").removeClass("show-form-error").addClass("form-error");

		if (!regex_name.test(name)) {
			$("#contactFormError0").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		}

		$("#contactFormError1").removeClass("show-form-error").addClass("form-error");

		if (!regex_lastname.test(surname)) {
			$("#contactFormError1").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		}

		$("#contactFormError2").removeClass("show-form-error").addClass("form-error");

		if (!regex_email.test(email)) {
			$("#contactFormError2").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		}

		$("#contactFormError3").removeClass("show-form-error").addClass("form-error");

		if (!regex_message.test(message)) {
			$("#contactFormError3").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		}
	});
});

/* Script used to validate login form */
$(document).ready(function() {
	$("#loginForm").validate({
		rules: {
			"login-username": {
				required: true
			},
			"login-password": {
				required: true
			}
		},
		messages: {
			"login-username": {
				required: "Please enter your username."
			},
			"login-password": {
				required: "Please enter your password."
			}
		},
		submitHandler: submitForm
	});

	function submitForm() {
		var data = $("#loginForm").serialize();

		$.ajax({
			type : 'POST',
			url : '../php/checkLogin.php',
			data : data,
			success : function(response) {
				if (response == "success") {
					$("#login_button").html('<img src="/res/loginLoad.svg" /> &nbsp; Logging In ...');
					setTimeout(' window.location.href = "index.php"; ', 4000);
				} else {
					$("#loginErr").fadeIn(1000, function() {
						$("#loginErr").html('<label class="error">' + response + '</label>');
					});
				}
			}
		});
		return false;
	}
});

/* Script used to validate registration form */
$(document).ready(function() {
	$("#signupForm").validate({
		rules: {
			"signup-name": {
				required: true,
				pattern: /^[A-Za-z]+((\s)?((\'|\-|\.)?([A-Za-z])+))*$/
			},
			"signup-username": {
				required: true,
				pattern: /^[a-zA-Z0-9]{3,16}$/,
				remote: '../php/checkUsername.php' // using AJAX to quickly check for pre-existing username
			},
			"signup-password": {
				required: true,
				pattern: /^[a-zA-Z0-9]{6,}$/
			}
		},
		messages: {
			"signup-name": {
				required: "Please enter your name.",
				pattern: "Name must contain only alphabetical letters."
			},
			"signup-username": {
				required: "Please enter your username.",
				pattern: "Username must be 3-16 characters long and contain only numbers and/or letters.",
				remote: "Username already exists."
			},
			"signup-password": {
				required: "Please enter your password.",
				pattern: "Password must be at least 6 characters long and contain only alphanumeric characters."
			}
		}
	});
});

