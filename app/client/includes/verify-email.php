<?php
// session_start();
include "includes/conn.php";
include "includes/phpmailer_cred.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// The email sending logic has been removed from this file. It should only be handled in email-verification.php.
?>

<script>
$(document).ready(function() {
    $("#VerificationModal").modal("show");
    console.log("modal-on");

    // Show loader when form is submitted
    $("#VerificationModal form").on("submit", function() {
        $("#loaderOverlay").css("display", "flex");
    });

    // Handle resend code button
    $("#resendCodeBtn").on("click", function() {
        $("#loaderOverlay").css("display", "flex");
        $.ajax({
            url: 'email-verification.php',
            method: 'POST',
            data: {
                resendVerification: true
            },
            success: function(response) {
                $("#loaderOverlay").css("display", "none");
                $("#resendFeedback").text(
                    "Verification code resent! Please check your email.").css("color",
                    "green").fadeIn().delay(3000).fadeOut();
            },
            error: function() {
                $("#loaderOverlay").css("display", "none");
                $("#resendFeedback").text(
                    "Failed to resend verification code. Please try again.").css(
                    "color", "red").fadeIn().delay(3000).fadeOut();
            }
        });
    });
});
</script>

<!-- Verification Modal -->
<div class="modal fade" id="VerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="VerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="VerificationModalLabel">Verify Email</h1>
            </div>
            <form action="email-verification.php" method="POST">
                <div class="modal-body">
                    <h6>Enter verification code sent to the email you have registered.</h6>
                    <div class="form-floating">
                        <input type="verificationCode" class="form-control" id="verificationCode"
                            placeholder="Email Address" name="verificationCode" required>
                        <label for="verificationCode">Verification Code</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="VerifyEmail">Confirm</button>
                    <button type="button" class="btn btn-link" id="resendCodeBtn">Click to send Code</button>
                </div>
                <div id="resendFeedback" class="w-100 text-center mt-2" style="display:none;"></div>
            </form>
        </div>
    </div>
</div>

<!-- Loader Overlay -->
<div id="loaderOverlay"
    style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.85); z-index:2000; justify-content:center; align-items:center;">
    <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
        <span class="visually-hidden">Sending...</span>
    </div>
    <div style="color:white; margin-top:20px; font-size:1.2rem;">Sending verification email...</div>
</div>