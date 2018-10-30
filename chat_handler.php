<?php
session_start();
$userinput = $_POST['userInput'];

# set presets
$_SESSION['presets']['userInput'] = $userinput;

// parse the contact name, keys, and values
// contact
preg_match('/^@[\w| ]{3,}/', $userinput, $contact);
$userinput = preg_replace('/^@[\w| ]{3,}/', ' ', $userinput);
$contact = ltrim(trim($contact[0]), '@');
// keys
preg_match_all('/(#[\w-]+)+/', $userinput, $keys);
$keys = $keys[0];
foreach($keys as &$k) {
  $k = ltrim(trim($k), '#');
}
//values
preg_match_all('/( [^#@][\w-]+)+/', $userinput, $values);
$values = $values[0];
foreach($values as &$v) {
  $v = ltrim(trim($v), '#');
}
//user_id
$userid = $_SESSION['userid'];

// check if correct
if (sizeof($keys) != sizeof($values)){
  $_SESSION['error_message'] = "Parsing error. Try again";
  header('Location: ./chat.php'); exit();
}

//make calls to dao
require_once 'dao.php';
$dao = new Dao();
for ($i = 0; $i < sizeof($keys); $i++) {
    echo "<br>addContactInfo($userid, $contact, {$keys[$i]}, {$values[$i]})";
    $dao->addContactInfo($userid, $contact, $keys[$i], $values[$i]);
}

header('Location: ./chat.php'); exit;

// #check if worked
// if ($r != 'DONE') {
//   $_SESSION['error_message'] = "Error creating user '$username' <br>" . print_r($r, true);
//   $_SESSION['logged_in'] = false;
//   header('Location: ./signup.php');
//   exit();
// } else {
//   $_SESSION['logged_in'] = true;
//   $_SESSION['username'] = $username;
//   $_SESSION['userid'] = $id;
//   header('Location: ./chat.php');
//   exit;
// }
