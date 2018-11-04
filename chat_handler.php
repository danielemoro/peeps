<?php
session_start();
$raw_userinput = $_POST['userInput'];
$userinput = $raw_userinput;

# set presets
$_SESSION['presets']['userInput'] = $userinput;

// parse the contact names, keys, and values
//question
$question = True;
preg_match('/[?]$/', $userinput, $questions);
if(empty($questions)){
  $question = False;
}
// contact
preg_match_all('/\B\@[\w| ]{3,}/', $userinput, $contacts);
$userinput = preg_replace('/\B\@[\w| ]{3,}/', '', $userinput);
if(empty($contacts) or empty($contacts[0])){
  $contacts = [];
}
foreach($contacts as &$c) {
  $c = ltrim(trim($c[0]), '@');
}
// keys
preg_match_all('/(#[\w-]+)+/', $userinput, $keys);
$keys = $keys[0];
foreach($keys as &$k) {
  $k = ltrim(trim($k), '#');
}
//values
preg_match_all('/( [^#@][\w-]+)+/', ' '.$userinput, $values);
$values = $values[0];
foreach($values as &$v) {
  $v = ltrim(trim($v), '#');
}
//user_id
$userid = $_SESSION['userid'];

echo $question;
echo print_r($contacts, 1);
echo print_r($values, 1);
echo print_r($keys, 1);

//make calls to dao
require_once 'dao.php';
$dao = new Dao();
$dao->addMessage($userid, 1, $raw_userinput);

if(!$question) {
  // check if correct
  if (sizeof($keys) != sizeof($values) or sizeof($keys) < 1){
    $error = "I'm sorry, I don't understand";
    $dao->addMessage($userid, 0, $error);
    header('Location: ./chat.php#bottom'); exit();
  }
  if(sizeof($contacts) != 1){
    $error = "Too many contact names listed. Try again";
    $dao->addMessage($userid, 0, $error);
    header('Location: ./chat.php#bottom'); exit();
  }

  $contact = $contacts[0];
  $contact_id = '';
  for ($i = 0; $i < sizeof($keys); $i++) {
      echo "<br>addContactInfo($userid, $contact, {$keys[$i]}, {$values[$i]})";
      $contact_id = $dao->addContactInfo($userid, $contact, $keys[$i], $values[$i]);
  }

  //add bot response
  $bot_response = "Got it! Added that information";
  $dao->addMessage($userid, 0, $bot_response);
  $dao->addMessage($userid, 0, $contact_id);
} else {
  $count = 0;
  $result_contacts = $dao->getContactsWith($userid, $contacts, $keys, $values);
  foreach($result_contacts as $i){
    if(count == 0){ $dao->addMessage($userid, 0, "I found some results from your search:"); }
    $count++;
    $contact_id = $i['contact_id'];
    $dao->addMessage($userid, 0, $contact_id);
  }

  if($count == 0){
    $bot_response = "No results found";
    $dao->addMessage($userid, 0, $bot_response);
  }
}

header('Location: ./chat.php#bottom'); exit;
