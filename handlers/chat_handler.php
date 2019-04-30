<?php
session_start();
require_once '../classes/contact_card.php';
require_once '../classes/dao.php';

$isAJAX = $_POST['ajax'];
$newMessages = [];

$raw_userinput = $_POST['userInput'];
$userinput = $raw_userinput;

# set presets
$_SESSION['presets']['userInput'] = $userinput;

// parse the contact names, keys, and values
//help
$help = True;
preg_match('/\bhelp\b/', $userinput, $helps);
if(empty($helps)){
  $help = False;
}

//find information
$findinfo = True;
preg_match('/find/m', $userinput, $findinfos); // ([a-zA-z]{2,}\s[a-zA-z]{2,})
if(empty($findinfos)){
  $findinfo = False; //TODO CHANGE THIS TO FALSE
}
$findinfo_update = True;
if(strlen($userinput) > 0){
  $findinfo_update = False; //TODO CHANGE THIS TO FALSE
}


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
  $c = trim(ltrim(trim($c[0]), '@'));
}
// keys
preg_match_all('/(#[\w-]+)+/', $userinput, $keys);
$keys = $keys[0];
foreach($keys as &$k) {
  $k = ltrim(trim($k), '#');
}
//values
preg_match_all('/( [^#@]+[\w-]+)+/', ' '.$userinput, $values);
$values = $values[0];
foreach($values as &$v) {
  $v = ltrim(trim($v), '#');
}
//user_id
$userid = $_SESSION['userid'];


//make calls to dao
$dao = new Dao();
if(strlen($userinput) > 0){
  $dao->addMessage($userid, 1, $raw_userinput);
  if($isAJAX){
    $newMessages[] = array(1, $raw_userinput);
  }
}

if ($findinfo_update) {
  $message = file_get_contents('../peeps_finder_out.txt', FILE_USE_INCLUDE_PATH);
  if(strlen(trim($message)) > 0){
    if(substr($message, 0, 1) == "["){
      file_put_contents('../peeps_finder_in.txt', 'END' . PHP_EOL, FILE_APPEND);
      $_SESSION['presets']['findinfo'] = False;
      file_put_contents('../peeps_finder_out.txt', '');

      $newinfo = json_decode($message, true);
      if (sizeof($newinfo) > 1){
        for ($i = 1; $i < sizeof($newinfo); $i++) {
            file_put_contents('../debug.txt', $userid . $newinfo[0][1] . $newinfo[$i][0] . $newinfo[$i][1] . PHP_EOL, FILE_APPEND);
            // echo "<br>addContactInfo($userid, $contact, {$keys[$i]}, {$values[$i]})";
            $contact_id = $dao->addContactInfo($userid, $newinfo[0][1], $newinfo[$i][0], $newinfo[$i][1]);
        }
        $bot_response = "Adding the verified information";
        $dao->addMessage($userid, 0, $bot_response);
        $card = new ContactCard($contact_id, $dao);
        $cardhtml = $card->drawCard();
        $dao->addMessage($userid, 0, $cardhtml);
        if($isAJAX){
          $newMessages[] = array(0, $bot_response);
          $newMessages[] = array(0, print_r($cardhtml, 1));
        }
      } else {
        $bot_response = "Adding no information";
        $dao->addMessage($userid, 0, $bot_response);
        if($isAJAX){
          $newMessages[] = array(0, $bot_response);
        }
      }
    } else {
      file_put_contents('../peeps_finder_out.txt', '');
      $message = "<li class=\"message response\">" . $message .  "</li>";
      //$_SESSION['presets']['userInput'] = $userinput;
      $dao->addMessage($userid, 0, $message);
      if($isAJAX){
        $newMessages[] = array(0, $message);
      }
    }


  }
} else if (in_array('findinfo', $_SESSION['presets']) AND $_SESSION['presets']['findinfo']) {
  file_put_contents('../peeps_finder_in.txt', $userinput . PHP_EOL, FILE_APPEND);

} else if ($findinfo) {
  file_put_contents('../peeps_finder_in.txt', "START" . PHP_EOL, FILE_APPEND);
  $_SESSION['presets']['findinfo'] = True;

} else if ($help) {
  $adding = "<li class=\"message response\"> <h1>Creating</h1>To create a new contact follow this format: @name #attribute description #attribute2 description2 ...<br>
  You can add as many attributes or values as you like. Remember that attributes must be all one word.
  <br> For example, try writing '@Peeps #likes yellow marshmallows' </li>";
  $search = "<li class=\"message response\"> <h1>Searching</h1>If you would like to search for any name, attribute, or value, simply follow your query with a '?' <br>
  For example try '@Peeps?', '#likes?' or 'yellow marshmallow?' </li>";
  $dao->addMessage($userid, 0, $adding);
  $dao->addMessage($userid, 0, $search);

  if($isAJAX){
    $newMessages[] = array(0, $adding);
    $newMessages[] = array(0, $search);
  }
} else if(!$question) {
  // check if correct
  if (sizeof($keys) != sizeof($values) or sizeof($keys) < 1){
    $error = "I'm sorry, I don't understand. Type 'help' if you need help";
    $dao->addMessage($userid, 0, $error);
    if($isAJAX){
      $newMessages[] = array(0, $error);
      echo json_encode($newMessages);
      exit();
    } else {
      header('Location: ../chat.php '); exit();
    }
  }
  if(sizeof($contacts) != 1){
    $error = "Invalid number of contact names. I require exactly one contact name denoted with @";
    $dao->addMessage($userid, 0, $error);
    if($isAJAX){
      $newMessages[] = array(0, $error);
      echo json_encode($newMessages);
      exit();
    } else {
      header('Location: ../chat.php '); exit();
    }
  }

  $contact = $contacts[0];
  $contact_id = '';
  for ($i = 0; $i < sizeof($keys); $i++) {
      // echo "<br>addContactInfo($userid, $contact, {$keys[$i]}, {$values[$i]})";
      $contact_id = $dao->addContactInfo($userid, $contact, $keys[$i], $values[$i]);
  }

  //add bot response
  $bot_response = "Got it! Added that information";
  $dao->addMessage($userid, 0, $bot_response);
  $card = new ContactCard($contact_id, $dao);
  $cardhtml = $card->drawCard();
  $dao->addMessage($userid, 0, $cardhtml);

  if($isAJAX){
    $newMessages[] = array(0, $bot_response);
    $newMessages[] = array(0, print_r($cardhtml, 1));
  }

} else {
  $count = 0;
  $result_contacts = $dao->getContactsWith($userid, $contacts, $keys, $values);
  foreach($result_contacts as $i){
    if($count == 0){
      $dao->addMessage($userid, 0, "I found some results from your search:");
      if($isAJAX){
        $newMessages[] = array(0, "I found some results from your search:");
      }
    }
    $count++;
    $contact_id = $i['contact_id'];
    $card = new ContactCard($contact_id, $dao);
    $cardhtml = $card->drawCard();
    $dao->addMessage($userid, 0, $cardhtml);

    if($isAJAX){
      $newMessages[] = array(0, print_r($cardhtml, 1));
    }
  }

  if($count == 0){
    $bot_response = "No results found";
    $dao->addMessage($userid, 0, $bot_response);

    if($isAJAX){
      $newMessages[] = array(0, $bot_response);
    }
  }
}

if($isAJAX){
  echo json_encode($newMessages);
} else {
  header('Location: ../chat.php '); exit;
}
