<?php
// Include your database connection code here
require_once '../database-connection.php';
session_start();

// store every error
$error = array();


// $error['email'] = "Phone Number/Email is empty!";
// $error['password'] = "Password is empty!!";

// Check if the form was submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email)){
        $error['email'] = "Email field is empty!";
    }

    if(empty($password)){
        $error['password'] = "Password field is empty!";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error['email'] = "Item typed is not an email!";
    }

    $query = "SELECT email, password from accounts WHERE email = ?";
    $user = fetch_all($query, [$email]);

    if(!empty($user)){
        if($password !== $user[0]['password'] || $email !== $user[0]['email'] ) {
            $error['login_credentials'] = "Login Credentials are wrong! Try Again";
        } else {
            $message = "Logged in!";
            // $_SESSION["loggedin"] = true;
            // $_SESSION["email"] = $email;
        }
    } else {
        $error['login_credentials'] = "Login Credentials are wrong! Try Again";
    }

}

// processes thru the AJAX
if($error){
    echo json_encode(['status' => "failed", 'message' => $error]);
} else {
    echo json_encode(['status' => 'success']);
}

?>