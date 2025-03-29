<?php 
session_start();
include "includes/conn.php";
include "includes/phpmailer_cred.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

function sendVerificationCode($email, $username, $token, $officialEmail, $officialEmailPassword) {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $officialEmail;
    $mail->Password   = $officialEmailPassword;
    $mail->SMTPSecure = "tls";
    $mail->Port       = "587";

    // Sender and recipient settings
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
}

function sendVerificationSuccessEmail($email, $username, $officialEmail, $officialEmailPassword) {
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $officialEmail;
    $mail->Password   = $officialEmailPassword;
    $mail->SMTPSecure = "tls";
    $mail->Port       = "587";

    // Sender and recipient settings
    $mail->setFrom($officialEmail, "Katipunan ng Kabataan Profiling System");
    $mail->addAddress($email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = "Account Verification Successful";

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
                .message {
                    font-size: 16px;
                    color: #555;
                }
                .success {
                    font-size: 22px;
                    font-weight: bold;
                    color: #28a745;
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
                <p class='message'>We are pleased to inform you that your email has been successfully verified. Your account is now fully activated, and you can access all features.</p>
                <p class='success'>Welcome to Katipunan ng Kabataan Profiling System!</p>
                <p class='message'>If you have any questions or need further assistance, feel free to reach out to our support team.</p>
                <p class='footer'>Best regards,<br><strong>Katipunan ng Kabataan Profiling System Team</strong></p>
            </div>
        </body>
        </html>
    ";

    $mail->Body = $email_template;
    $mail->send();
}



if (isset($_POST['sendVerification']) && $_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $userID = $_SESSION['user']['id'];
    $username = $_SESSION['user']['user_username'];
    $token = rand(100000, 999999);

    $stmt = $conn->prepare("UPDATE accounts SET verificationCode = ?, email = ? WHERE id = ? AND username = ?");
    $stmt->bind_param("ssis", $token, $email, $userID, $username);

    if ($stmt->execute()) {
        sendVerificationCode($email, $username, $token, $officialEmail, $officialEmailPassword);
        
        $_SESSION['entered_email'] = $email;
        $_SESSION['email_sent'] = true;
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Verification code sent!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    }else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Try Again";
    }

    $stmt->close();
    // Redirect
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['VerifyEmail'])) {
    
    $verifyCode = mysqli_real_escape_string($conn, $_POST['verificationCode']);
    $userID = $_SESSION['user']['id'];
    $username = $_SESSION['user']['user_username'];
    $email = $_SESSION['entered_email'];
         

    // Prepare and execute the query
    $checkCode = "SELECT verificationCode FROM accounts WHERE id = ? AND username = ?";
    $stmt = mysqli_prepare($conn, $checkCode);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $userID, $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $dbVerificationCode);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Check if the verification code matches
        if ($dbVerificationCode) {
            if ($verifyCode === $dbVerificationCode) {
                // Update account to mark email as verified
                $updateQuery = "UPDATE accounts SET email_verify = 1 WHERE id = ?";
                $updateStmt = mysqli_prepare($conn, $updateQuery);
                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "i", $userID);
                    mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt);
                    
                    $_SESSION['status'] = "Success!";
                    $_SESSION['status_text'] = "Your email has been successfully verified.";
                    $_SESSION['status_code'] = "success";
                    $_SESSION['status_btn'] = "Done";

                    sendVerificationSuccessEmail($email, $username, $officialEmail, $officialEmailPassword);
                    unset($_SESSION['entered_email']);
                    unset($_SESSION['email_sent']);
                } else {
                    $_SESSION['status'] = "Database Error!";
                    $_SESSION['status_text'] = "Could not update verification status.";
                    $_SESSION['status_code'] = "error";
                    $_SESSION['status_btn'] = "Try Again";

                }
            } else {
                $_SESSION['status'] = "Invalid Code!";
                $_SESSION['status_text'] = "The verification code you entered is incorrect.";
                $_SESSION['status_code'] = "error";
                $_SESSION['status_btn'] = "Retry";
            }
        } else {
            $_SESSION['status'] = "Error!";
            $_SESSION['status_text'] = "No verification code found for this account.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Retry";
        }
    } else {
        $_SESSION['status'] = "Database Error!";
        $_SESSION['status_text'] = "Failed to execute the query.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Try Again";
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>