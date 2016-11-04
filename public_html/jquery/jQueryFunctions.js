/* Script used to import navbar */
$(document).ready(function() {
    $("#header").load("header.html");
});

/* Script used to import footer */
$(document).ready(function() {
    $("#footer").load("footer.html");
});

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

/* Script used to validate contact form */
$(document).ready(function() {
	$("#contact-submit").click(function(event) {
		var name = $("#form_name").val();
		var surname = $("#form_lastname").val();
		var email = $("#form_email").val();
		var message = $("#form_message").val();
		var regex_name = /[a-zA-Z0-9]+/;
		var regex_lastname = /[a-zA-Z0-9]+/;
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

/*$(document).ready(function(event) {
 	 $("#login_button").click(function(){
 	 	$("#login_change").replaceWith(
 	 		'<li><a href="#"><span class="glyphicon glyphicon-user"></span>Logout</a></li>' );

 	});

});*/

$(function(){
    $(document).on("click", "#login_button", function(event){
    	$("#login_change").replaceWith(
 	 		' <ul class="nav navbar-nav navbar-right">'+
 	 		'<li><a href="#"><span class="glyphicon glyphicon-cog"></span> Manage Account</a></li>'+
 	 		'<li><a data-toggle="modal" href="#myModal"><span class="glyphicon glyphicon-log-in"> Logout</a></li>'+
 	 		'</ul>' );
    }); 
});

$(function(){
    $(document).on("click", "#login_button", function(event){
    	$("#login_change").replaceWith(
 	 		' <ul class="nav navbar-nav navbar-right">'+
 	 		'<li><a href="signup_html"><span class="glyphicon glyphicon-cog"></span> Signup</a></li>'+
 	 		'<li><a data-toggle="modal" href="#myModal"><span class="glyphicon glyphicon-log-in"> Login</a></li>'+
 	 		'</ul>' );
    }); 
});









