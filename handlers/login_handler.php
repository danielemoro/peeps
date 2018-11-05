<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

# set presets
$_SESSION['presets']['username'] = $username;

# sanitize data
$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

# ask database for information
require_once '../classes/dao.php';
$dao = new Dao();
$id = $dao->getUserId($username, $password);

# check if the id works
if (!$id) {
  $_SESSION['logged_in'] = false;
  $_SESSION['error_message'] = "Username or password is invalid";
  header('Location: ../login.php');
  exit;
} else {
  unset($_SESSION['CREATED']);
  $_SESSION['logged_in'] = true;
  $_SESSION['username'] = $username;
  $_SESSION['userid'] = $id;
  header('Location: ../chat.php ');
  exit;
}
