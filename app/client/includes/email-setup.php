<?php 
if ($_SESSION['email_sent'] === true) {
?>
<script>
$(document).ready(function() {
    $("#VerificationModal").modal("show");
    console.log("verified modal-on");
});
</script>
<?php
}else {
?>
<script>
$(document).ready(function() {
    $("#setUpModal").modal("show");
    console.log("modal-on");
});
</script>
<?php
}
?>


<!-- Set Up Email Modal -->
<div class="modal fade" id="setUpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="setUpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="setUpModalLabel">Set Up your Email</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form action="email-verification.php" method="POST">
                <div class="modal-body">
                    <h6>It seems that you haven't set up your <span class="fw-bold text-danger">email</span>. Please
                        enter your email to verify your account.</h6>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" placeholder="Email Address" name="email"
                            required>
                        <label for="email">Email Address</label>
                        <div id="emailFeedback"></div> <!-- Feedback message -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="sendVerification">
                        Send Verification Code
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Set Up Email Modal -->
<div class="modal fade" id="VerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="VerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="VerificationModalLabel">Verify Email</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <form action="email-verification.php" method="POST">
                <div class="modal-body">
                    <h6>Enter verification code sent to the email you have entered earlier.</h6>
                    <div class="form-floating">
                        <input type="verificationCode" class="form-control" id="verificationCode"
                            placeholder="Email Address" name="verificationCode" required>
                        <label for="verificationCode">Verification Code</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary" name="VerifyEmail">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Loader Overlay -->
<div id="loaderOverlay"
    style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.85); z-index:2000; justify-content:center; align-items:center;">
    <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <div style="color:white; margin-top:20px; font-size:1.2rem;">Sending verification email...</div>
</div>

<!-- jQuery (Ensure jQuery is included in your project) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Show loader when form is submitted
    $("#setUpModal form").on("submit", function() {
        $("#loaderOverlay").css("display", "flex");
    });

    $("#email").on("keyup", function() {
        var email = $(this).val().trim(); // Get input value

        if (email !== "") {
            $.ajax({
                url: "check_email.php", // PHP script to check email
                method: "POST",
                data: {
                    email: email
                },
                success: function(response) {
                    if (response === "taken") {
                        $("#email").addClass("is-invalid").removeClass("is-valid");
                        $("#emailFeedback").html(
                            '<span class="text-danger">This email is already in use.</span>'
                        );
                    } else {
                        $("#email").addClass("is-valid").removeClass("is-invalid");
                        $("#emailFeedback").html(
                            '<span class="text-success">This email is available.</span>'
                        );
                    }
                }
            });
        } else {
            $("#email").removeClass("is-valid is-invalid");
            $("#emailFeedback").html(""); // Clear feedback
        }
    });
});
</script>