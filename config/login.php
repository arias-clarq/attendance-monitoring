<?php
session_start();
include_once ("dbcon.php");

//user login
function user_login($login_user, $login_pass, $user, $pass)
{
    if ($user == $login_user && $pass == $login_pass) {
        // echo 'correct';
        return true;
    } else {
        // echo 'incorrect';
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_login = false;
    $role_check = array('Admin', 'Employee');

    // API endpoint URL
    $api_url = "https://cyber-techo.000webhostapp.com/config/api.php";

    // Initialize cURL session
    $ch = curl_init($api_url);

    // Set options to receive response as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Decode the JSON response
    $api_response = json_decode($response, true);

    // Check each user's credentials in the JSON array
    foreach ($api_response as $data) {
        $employee = $data['employee'];
        $user_login = user_login($username, $password, $employee['username'], $employee['password']);

        if ($user_login == true) {
            // $_SESSION['token'] = true;
            // $_SESSION['username'] = $username;
            // $_SESSION['employeeID'] = $employee['employeeID'];
            $_SESSION['login_role'] = $employee['login_role'];
            break;
        }
    }

    if ($user_login == true) {
        if($role_check[0] == $_SESSION['login_role']){
            echo 'your admin';
            // header("location: ../admin/dashboard.php");
        }else if($role_check[1] == $_SESSION['login_role']){
            // header("location: ../admin/dashboard.php");
            echo 'your employee';
        }
    } else {
        $_SESSION['message'] = 'Incorrect Username or Password';
        header('location: ../index.php');
    }
}
?>