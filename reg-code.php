<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['CreateAcc'])) {
    $firstname = $conn->real_escape_string($_POST['firstName']);
    $lastname = $conn->real_escape_string($_POST['lastName']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Default barangay code and role for registration
    $role = "Administrative";
    $brgy_code = "Admin";


    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_reg = "INSERT INTO `accounts`(`brgy_code`,`username`, `password`, `firstname`, `lastname`, `role`) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql_reg);
    $stmt->bind_param("ssssss", $brgy_code,$username, $hashed_password, $firstname, $lastname, $role);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Registration successful!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $sql . "<br>" . $conn->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    $stmt->close();
    // $conn->close();
}

// Log in Password
if (isset($_POST['admin-login'])) {
    // Get form data

    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check if account exists
    $checkQuery = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
    $checkQuery->bind_param("s", $username);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows == 0) {
        // If account does not exists
        $_SESSION['status'] = "Account not Found!";
        $_SESSION['status_text'] = "Your account doest no exists.";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // If the account does exist, verify and fetch hashed password from the database
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, now verify password
            $user = $result->fetch_assoc();
            $hashed_password = $user['password'];

            if (password_verify($password, $hashed_password)) {
              // Password is correct, set session variables
              $_SESSION['admin_auth'] = true;
              $_SESSION['user'] = [
              'id' => $user['id'],
              'user_username'=> $user['username'],
                ];

              // Successful login
              $_SESSION['logged'] = "Login Successful!";
              $_SESSION['logged_icon'] = "success";
              header("Location: app/admin/homepage"); // Redirect to dashboard or user page
              exit();
          } else {
              // Invalid password
              $_SESSION['entered_username'] = $username;
              $_SESSION['status'] = "Invalid Password!";
              $_SESSION['status_text'] = "Incorrect password. Please try again.";
              $_SESSION['status_code'] = "error";
              $_SESSION['status_btn'] = "Back";
              header("Location: {$_SERVER['HTTP_REFERER']}");
              exit();
          }
      } else {
          // Invalid username
          $_SESSION['status'] = "Invalid Username!";
          $_SESSION['status_text'] = "Incorrect username. Please try again.";
          $_SESSION['status_code'] = "error";
          $_SESSION['status_btn'] = "Back";
          header("Location: {$_SERVER['HTTP_REFERER']}");
          exit();
      }
    }
}

if (isset($_POST['sk-login'])) {
    // Get form data

    $brgy_code = $conn->real_escape_string($_POST['barangayCode']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check if account exists
    $checkQuery = $conn->prepare("SELECT * FROM accounts WHERE username = ? AND brgy_code = ?");
    $checkQuery->bind_param("ss", $username, $brgy_code);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows == 0) {
        // If account does not exists
        $_SESSION['status'] = "Account not Found!";
        $_SESSION['status_text'] = "Your account doest no exists.";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // If the account does exist, verify and fetch hashed password from the database
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = ? AND brgy_code = ?");
        $stmt->bind_param("ss", $username, $brgy_code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, now verify password
            $user = $result->fetch_assoc();
            $hashed_password = $user['password'];
            $currentBrgy = $user['brgy_code'];

            if (password_verify($password, $hashed_password)) {
              // Password is correct, set session variables
              $_SESSION['client_auth'] = true;
              $_SESSION['user'] = [
              'id' => $user['id'],
              'user_username'=> $user['username'],
                ];

              // Successful login
              $_SESSION['logged'] = "Login Successful!";
              $_SESSION['logged_icon'] = "success";
              header("Location: app/client/homepage?Code=$currentBrgy"); // Redirect to dashboard or user page
              exit();
          } else {
              // Invalid password
              $_SESSION['entered_username_sk'] = $username;
              $_SESSION['status'] = "Invalid Password!";
              $_SESSION['status_text'] = "Incorrect password. Please try again.";
              $_SESSION['status_code'] = "error";
              $_SESSION['status_btn'] = "Back";
              header("Location: {$_SERVER['HTTP_REFERER']}");
              exit();
          }
      } else {
          // Invalid username
          $_SESSION['status'] = "Invalid Username!";
          $_SESSION['status_text'] = "Incorrect username. Please try again.";
          $_SESSION['status_code'] = "error";
          $_SESSION['status_btn'] = "Back";
          header("Location: {$_SERVER['HTTP_REFERER']}");
          exit();
      }
    }
}

?>