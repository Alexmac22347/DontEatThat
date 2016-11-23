/* Script used to validate food form */
$(document).ready(function() {
	$("#food-submit").click(function(event) {
		var item1 = $("#item1").val().trim();
		var item2 = $("#item2").val().trim();
		console.log(item1);
		console.log(item2);
		$("#foodFormError0").removeClass("show-form-error").addClass("form-error");
		$("#foodFormError1").removeClass("show-form-error").addClass("form-error");

		if (item1 == null || item1 == "" || item2 == null || item2 == "") {
			// if empty
			$("#foodFormError0").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		} else if (item1 == item2) {
			// if same input
			$("#foodFormError1").removeClass("form-error").addClass("show-form-error");
			event.preventDefault();
		}
	});
});

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
					$("#loginErr").hide();
					$("#login_button").html('<img src="/res/loginLoad.svg" /> &nbsp; Logging In ...');
					setTimeout(' window.location.href = "index.php"; ', 3300);
				} else {
					$("#loginErr").fadeIn(1000, function() {
						//$("#loginErr").html('<label class="error">' + response + '</label>');
						$("#loginErr").html('<div class="alert alert-danger alert-dismissable fade in">' + 
												'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + 
												response + 
											'</div>');
					});
				}
			}
		});
		return false;
	}
});

/* Script used for autocomplete */
$(document).ready(function() {
	$("#item1").keyup(function() {
		var data = $("#foodItemsForm").serialize();

		$.ajax({
			type : 'GET',
			url : '../php/autocomplete.php?item=1',
			data : data,
			success : function(response) {
				var json = JSON.parse(response).suggestions.suggestion;
				$("#item1").autocomplete({
					source : json
				});
			}
		});
	});
});

/* Script used for autocomplete 2*/
$(document).ready(function() {
	$("#item2").keyup(function() {
		var data = $("#foodItemsForm").serialize();
	
		$.ajax({
			type : 'GET',
			url : '../php/autocomplete.php?item=2',
			data : data,
			success : function(response) {
				var json = JSON.parse(response).suggestions.suggestion;
				$("#item2").autocomplete({
					source : json
				});
			}
		});
	});
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

/* Script used to validate account updates */
$(document).ready(function() {
	$("#save-button").click(function(event) {
		event.preventDefault();
		updateForm();
	});

	function updateForm() {
		var data = $("#updateForm").serialize();

		$.ajax({
			type : 'POST',
			url : '../php/checkUpdate.php',
			data : data,
			success : function(response) {
				if (response == "same pass") {
					$("#updateErr").html('<div class="alert alert-danger alert-dismissable fade in">' + 
											'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + 
											'The password you have entered is the same as the one you had before. Please enter a different password.' + 
										 '</div>');
				} else if (response == "same prefs") {
					$("#updateErr").html('<div class="alert alert-danger alert-dismissable fade in">' + 
											'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + 
											'Error: Your meal preferences did not change!' + 
										 '</div>');
				} else if (response == "success") {
					$("#updateErr").hide();
					update();
					setTimeout(' window.location.href = "../index.php"; ', 0);
				}
			}
		});
	}

	function update() {
		var data = $("#updateForm").serialize();

		$.ajax({
			type : 'POST',
			url : '../php/accountUpdate.php',
			data : data
		});
	}
});
