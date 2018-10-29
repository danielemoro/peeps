<?php
require_once 'KLogger.php';

class Dao {
  //CLEARDB_DATABASE_URL: mysql://ba6b95c5bb543d:489ef638@us-cdbr-iron-east-01.cleardb.net/heroku_bc7a594b677ccd7?reconnect=true

  private $host = "us-cdbr-iron-east-01.cleardb.net";
  private $db = "heroku_bc7a594b677ccd7";
  private $user = "ba6b95c5bb543d";
  private $pass = "489ef638";
  private $log;

  public function __construct () {
    $this->log = new KLogger("log.txt", KLogger::INFO);
  }

  public function getConnection () {
    try {
      $conn= new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user,
         $this->pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
      $this->log->LogFatal($e);
    }
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

}
