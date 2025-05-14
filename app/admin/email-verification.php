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

// Function to check email verification status
function checkEmailVerificationStatus($conn, $userID, $username) {
    $query = "SELECT email, email_verify FROM accounts WHERE id = ? AND username = ? AND role = 'Administrative'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $userID, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    return [
        'has_email' => !empty($row['email']),
        'is_verified' => $row['email_verify'] == 1,
        'email' => $row['email'] ?? null
    ];
}

// Function to handle email verification process
function handleEmailVerification($conn, $userID, $username, $email = null) {
    $status = checkEmailVerificationStatus($conn, $userID, $username);
    
    if (!$status['has_email'] && !$email) {
        return [
            'status' => 'error',
            'message' => 'Email address is required for verification.',
            'action' => 'setup_email'
        ];
    }
    
    if ($status['is_verified']) {
        return [
            'status' => 'success',
            'message' => 'Email is already verified.',
            'action' => 'none'
        ];
    }
    
    // Generate new verification code
    $token = rand(100000, 999999);
    $email = $email ?? $status['email'];
    
    $stmt = $conn->prepare("UPDATE accounts SET verificationCode = ?, email = ? WHERE id = ? AND username = ? AND role = 'Administrative'");
    $stmt->bind_param("ssis", $token, $email, $userID, $username);
    
    if ($stmt->execute()) {
        global $officialEmail, $officialEmailPassword;
        sendVerificationCode($email, $username, $token, $officialEmail, $officialEmailPassword);
        
        $_SESSION['entered_email'] = $email;
        $_SESSION['email_sent'] = true;
        
        return [
            'status' => 'success',
            'message' => 'Verification code sent successfully.',
            'action' => 'verify_code'
        ];
    }
    
    return [
        'status' => 'error',
        'message' => 'Failed to send verification code.',
        'action' => 'retry'
    ];
}

// Handle email setup request
if (isset($_POST['sendVerification']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $userID = $_SESSION['user']['id'];
    $username = $_SESSION['user']['user_username'];
    
    $result = handleEmailVerification($conn, $userID, $username, $email);
    
    $_SESSION['status'] = ucfirst($result['status']) . "!";
    $_SESSION['status_text'] = $result['message'];
    $_SESSION['status_code'] = $result['status'];
    $_SESSION['status_btn'] = $result['action'] === 'retry' ? "Try Again" : "Done";
    
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Handle verification code submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['VerifyEmail'])) {
    $verifyCode = mysqli_real_escape_string($conn, $_POST['verificationCode']);
    $userID = $_SESSION['user']['id'];
    $username = $_SESSION['user']['user_username'];
    $email = $_SESSION['entered_email'];
    
    $checkCode = "SELECT verificationCode FROM accounts WHERE id = ? AND username = ? AND role = 'Administrative'";
    $stmt = mysqli_prepare($conn, $checkCode);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $userID, $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $dbVerificationCode);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        if ($dbVerificationCode && $verifyCode === $dbVerificationCode) {
            $updateQuery = "UPDATE accounts SET email_verify = 1 WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            
            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, "i", $userID);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);
                
                sendVerificationSuccessEmail($email, $username, $officialEmail, $officialEmailPassword);
                
                $_SESSION['status'] = "Success!";
                $_SESSION['status_text'] = "Your email has been successfully verified.";
                $_SESSION['status_code'] = "success";
                $_SESSION['status_btn'] = "Done";
                
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
        $_SESSION['status'] = "Database Error!";
        $_SESSION['status_text'] = "Failed to execute the query.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Try Again";
    }
    
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

// Handle AJAX resend verification code request
if (isset($_POST['resendVerification'])) {
    $userID = $_SESSION['user']['id'];
    $username = $_SESSION['user']['user_username'];
    $status = checkEmailVerificationStatus($conn, $userID, $username);
    $email = $status['email'];
    if ($email) {
        // Generate new code and update DB
        $token = rand(100000, 999999);
        $stmt = $conn->prepare("UPDATE accounts SET verificationCode = ? WHERE id = ? AND username = ? AND role = 'Administrative'");
        $stmt->bind_param("sis", $token, $userID, $username);
        if ($stmt->execute()) {
            global $officialEmail, $officialEmailPassword;
            sendVerificationCode($email, $username, $token, $officialEmail, $officialEmailPassword);
            $_SESSION['entered_email'] = $email;
            echo 'success';
            exit();
        } else {
            echo 'db_error';
            exit();
        }
    } else {
        echo 'no_email';
        exit();
    }
}
?>