<?php
session_start();
include "includes/conn.php";
include "includes/phpmailer_cred.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Get session user details
$userID = $_SESSION['user']['id'];
$username = $_SESSION['user']['user_username'];
$token = rand(100000, 999999);

$stmt = $conn->prepare("UPDATE accounts SET verificationCode = ? WHERE id = ? AND username = ? AND role = 'Administrative'");
$stmt->bind_param("sis", $token, $userID, $username);

if ($stmt->execute()) {
    echo "script>console.log('Verification code sent!');</script>";
    $_SESSION['entered_email'] = $email;
}else{
    echo "script>console.log('Verification code cannot be sent!');</script>";
}
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $officialEmail;
    $mail->Password   = $officialEmailPassword;
    $mail->SMTPSecure = "tls";
    $mail->Port       = "587";                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom($officialEmail, "Katipunan ng Kabataan Profiling System");
    $mail->addAddress($email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = "Account Verification Code";

    $email_template = "
        <html>
        <head>
            <style>
                .container {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                    border-radius: 5px;
                }
                .header {
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                }
                .otp {
                    font-size: 22px;
                    font-weight: bold;
                    color: #d9534f;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 14px;
                    color: #777;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <p class='header'>Hello $username,</p>
                <p>We received a request to verify your email address. Please use the following One-Time Password (OTP) to complete your email verification process:</p>
                <p class='otp'>$token</p>
                <p>If you did not request this verification, please ignore this email or contact support immediately.</p>
                <p class='footer'>Best regards,<br><strong>Katipunan ng Kabataan Profiling System</strong></p>
            </div>
        </body>
        </html>
    ";

    $mail->Body = $email_template;
    $mail->send();
    echo 'Verification code has been sent successfully.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



?>

<script>
$(document).ready(function() {
    $("#VerificationModal").modal("show");
    console.log("modal-on");
});
</script>



<!-- Verification Modal -->
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
                    <h6>Enter verification code sent to the email you have registered.</h6>
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