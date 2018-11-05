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
  header('Location: ../signup.php');
  exit();
}

# sanitize data
$username = filter_var($username, FILTER_SANITIZE_STRING);
$password = filter_var($password, FILTER_SANITIZE_STRING);

# ask database to add user
require_once '../classes/dao.php';
$dao = new Dao();
$r = $dao->addUser($username, $password);

#check if worked
if ($r != 'DONE') {
  $_SESSION['error_message'] = "Error creating user '$username' <br>" . print_r($r, true);
  $_SESSION['logged_in'] = false;
  header('Location: ../signup.php');
  exit();
} else {
  unset($_SESSION['CREATED']);
  $_SESSION['logged_in'] = true;
  $_SESSION['username'] = $username;
  $_SESSION['userid'] = $dao->getUserId($username, $password);

  #create welcome $messages
  $userid = $_SESSION['userid'] ;
  $welcome = "<li class=\"message response\"> <h1>Welcome!</h1>My name is Peeps, and I'm here to help you manage your contacts. <br>I do this by leveraging a simple chat interface </li>";
  $adding = "<li class=\"message response\"> <h1>Creating</h1>To create a new contact follow this format: @name #attribute description #attribute2 description2 ...<br>
  You can add as many attributes or values as you like. Remember that attributes must be all one word.
  <br> For example, try writing '@Peeps #likes yellow marshmallows' </li>";
  $search = "<li class=\"message response\"> <h1>Searching</h1>If you would like to search for any name, attribute, or value, simply follow your query with a '?' <br>
  For example try '@Peeps?', '#likes?' or 'yellow marshmallow?' </li>";
  $final = "<li class=\"message response\"> If you have further questions, click <a href=\"mailto:moro.daniele@gmail.com\"> here </a> </li>";
  $dao->addMessage($userid, 0, $welcome);
  $dao->addMessage($userid, 0, $adding);
  $dao->addMessage($userid, 0, $search);
  $dao->addMessage($userid, 0, $final);

  header('Location: ../chat.php ');
  exit;
}
