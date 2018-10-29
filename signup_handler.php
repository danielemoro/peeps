<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

# set presets
$_SESSION['presets']['username'] = $username;

# validiate data
$allgood = True;
if(preg_match('/[\W]+/', $username)) {
  $_SESSION['error_message'] = "Username contains invalid characters <br>
                                Only letters, numbers, and underscores are valid";
  $allgood = False;
} elseif (preg_match('/([\w]{20,}|^\s*$)/', $username)) {
  $_SESSION['error_message'] = "Invalid username length";
  $allgood = False;
} elseif (preg_match('/([\w]{20,}|^\s*$)/', $password)) {
  $_SESSION['error_message'] = "Invalid password length";
  $allgood = False;
}
if(!$allgood){
  header('Location: ./signup.php');
  exit();
}

# sanitize data
$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

# ask database to add user
require_once 'dao.php';
$dao = new Dao();
$r = $dao->addUser($username, $password);

#check if worked
if ($r != 'DONE') {
  $_SESSION['error_message'] = "Error creating user '$username' <br>" . print_r($r, true);
  $_SESSION['logged_in'] = false;
  header('Location: ./signup.php');
  exit();
} else {
  $_SESSION['logged_in'] = true;
  $_SESSION['user'] = $username;
  header('Location: ./chat.php');
  exit;
}
