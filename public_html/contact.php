<?php 
    $title = "Contact";
    include("layout/header.php"); 
    ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <h2 style="padding-left: 0;">Contact</h2>
            <p style="padding-left: 0; padding-top: 0;">
                We are here to answer any questions you may have about our services. Please use the form below and we'll respond as soon as we can.
            </p>
            <form id="contact-form" method="post" action="php/sendEmail.php" role="form">
                <div class="controls">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_name">First name</label>
                                <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your first name">
                                <p id="contactFormError0" class="form-error">First name is required.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_lastname">Last name</label>
                                <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your last name">
                                <p id="contactFormError1" class="form-error">Last name is required.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_email">Email</label>
                                <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email">
                                <p id="contactFormError2" class="form-error">Valid email is required.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="form_message">Message</label>
                                <textarea id="form_message" name="message" class="form-control" placeholder="Your message" rows="4"></textarea>
                                <p id="contactFormError3" class="form-error">Please enter your message.</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input id="contact-submit" type="submit" class="btn btn-success btn-send" value="Send message">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p style="padding-left: 0;" class="text-muted">All fields are required.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "layout/footer.php" ?>
