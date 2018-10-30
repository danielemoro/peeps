<?php
require_once 'KLogger.php';

class Dao {
  //CLEARDB_DATABASE_URL: mysql://ba6b95c5bb543d:489ef638@us-cdbr-iron-east-01.cleardb.net/heroku_bc7a594b677ccd7?reconnect=true

  private $host = "us-cdbr-iron-east-01.cleardb.net";
  private $db = "heroku_bc7a594b677ccd7";
  private $user = "ba6b95c5bb543d";
  private $pass = "489ef638";
  private $log;
  private $conn;

  public function __construct () {
    $this->log = new KLogger("log.txt", KLogger::INFO);
  }

  public function getConnection () {
    if(isset($this->conn)){
      return $this->conn;
    }

    try {
      $conn= new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user,
         $this->pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (Exception $e) {
      $this->log->LogFatal($e);
      header('Location: ./fatalerror.php');
      exit();
    }

    $this->conn = $conn;
    return $conn;
  }

  public function getUserId ($username, $password) {
    $this->log->LogDebug("Getting user id for $username");
    $conn = $this->getConnection();
    $getQuery = "select user_id from users where username=:username and password=:password";
    $q = $conn->prepare($getQuery);
    $q->bindParam(":username", $username);
    $q->bindParam(":password", $password);
    $q->execute();
    $id = reset($q->fetchAll());
    if (isset($id) and $id['user_id']) {
      return $id['user_id'];
    } else {
      return False;
    }
 }

 public function addUser ($username, $password) {
   try {
     $this->log->LogDebug("Creating new user $username");
     $conn = $this->getConnection();
      $saveQuery =
          "INSERT INTO users
          (username, password)
          VALUES
          (:username, :password)";
      $q = $conn->prepare($saveQuery);
      $q->bindParam(":username", $username);
      $q->bindParam(":password", $password);
      $q->execute();
      return 'DONE';
    } catch(PDOException $e) {
      switch($e->getCode()){
        case 23000:
          return "Username already taken";
        default:
          return "Database error. Try again";
      }
    }
  }

  public function getContactID($userid, $contact) {
    $conn = $this->getConnection();
    $getQuery = "SELECT contact_id FROM contacts
         WHERE owner=:owner AND contact_name=:contact";
    $q = $conn->prepare($getQuery);
    $q->bindParam(":owner", $userid);
    $q->bindParam(":contact", $contact);
    $q->execute();
    $result = $q->fetchAll();
    if (isset($result[0][0])) {
     return $result[0][0];
    } else {
      return False;
    }
  }

  public function createContact($userid, $contact) {
    $conn = $this->getConnection();
    $saveQuery =
       "INSERT INTO contacts (owner, contact_name)
       VALUES (:owner, :contact);";
    $q = $conn->prepare($saveQuery);
    $q->bindParam(":owner", $userid);
    $q->bindParam(":contact", $contact);
    $q->execute();
  }

  public function addContactInfo($userid, $contact, $key, $attribute) {
      $this->log->LogDebug("Setting $contact:$key to $attribute");
      $contact_id = $this->getContactID($userid, $contact);

      # make contact if doesn't exist
      if(!$contact_id){
          $this->createContact($userid, $contact);
          $contact_id = $this->getContactID($userid, $contact);
          if(!$contact_id) {
            $this->log->LogFatal("Could not create new contact $contact");
            header('Location: ./fatalerror.php'); exit();
          }
      }

      #insert attributes
      $conn = $this->getConnection();
      $saveQuery =
         "INSERT INTO attributes (contact_id, attr, value)
         VALUES (:contact_id, :key, :value)
         ON DUPLICATE KEY UPDATE value=:value ";
      $q = $conn->prepare($saveQuery);
      $q->bindParam(":contact_id", $contact_id);
      $q->bindParam(":key", $key);
      $q->bindParam(":value", $attribute);
      $q->execute();
  }

  // public function getContactsWith($keys, $values) {
  //   for($keys as $k)
  //   $conn = $this->getConnection();
  //   $getQuery = "SELECT DISTINCT c.contact_id FROM
  //               attributes a JOIN contacts c ON a.contact_id=c.contact_id
  //               where"; // attr='color' and value='red';
  //
  //   // TODO finish this
  //
  //   $q = $conn->prepare($getQuery);
  //   $q->bindParam(":owner", $userid);
  //   $q->bindParam(":contact", $contact);
  //   $q->execute();
  //   $result = $q->fetchAll();
  //   if (isset($result[0][0])) {
  //    return $result[0][0];
  //   } else {
  //     return False;
  //   }
  // }

}
