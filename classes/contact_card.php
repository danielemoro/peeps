<?php

class ContactCard {
  private $contact_id;
  private $contact_name;
  private $date_added;
  private $attrs;
  private $values;
  private $listclass;
  private $contactDate;
  private $dao;

  public function __construct ($contact_id, $dao, $listclass='chatContactCard', $contactDate=False) {
    $this->contact_id = $contact_id;
    $this->listclass = $listclass;
    $this->contactDate = $contactDate;
    $this->dao = $dao;
  }

  public function getCardInfo() {
    if(!isset($this->contact_id)){
      header('Location: ../fatalerror.php'); exit();
    }

    $info = $this->dao->getContactInfo($this->contact_id);
    $this->contact_name = $info[0]['contact_name'];
    $this->date_added = end($info[0]);

    foreach($info as $row){
      $this->attrs[] = $row['attr'];
      $this->values[] = $row['value'];
    }

    if (sizeof($this->attrs) != sizeof($this->values)){
      header('Location: ../fatalerror.php'); exit();
    }
  }

  public function drawCard () {
    $this->getCardInfo();
    $contact_name = filter_var($this->contact_name, FILTER_SANITIZE_STRING);
    $html =
    "<li class=\"{$this->listclass}\">
        <div class=\"contactCard\">
            <b> {$contact_name} </b>
            <hr>
            <table> ";
    for($i = 0; $i < sizeof($this->attrs); $i++){
      $attr = filter_var($this->attrs[$i], FILTER_SANITIZE_STRING);
      $val = filter_var($this->values[$i], FILTER_SANITIZE_STRING);
      $html .= "<tr> <th>#{$attr}</th> <td>{$val}</td> </tr>";
    }
    $html .=  " </table> </div> ";
    if($this->contactDate) {
      $html .= "<div class=\"contactDate\">{$this->date_added}</div>";
    }
    $html .= "</li>";
    return $html;
  }
}
