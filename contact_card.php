<?php

class ContactCard {
  private $contact_id;
  private $contact_name;
  private $attrs;
  private $values;

  public function __construct ($contact_id) {
    $this->contact_id = $contact_id;
  }

  public function getCardInfo() {
    if(!isset($this->contact_id)){
      header('Location: ./fatalerror.php'); exit();
    }

    require_once 'dao.php';
    $dao = new Dao();
    $info = $dao->getContactInfo($this->contact_id);
    $this->contact_name = $info[0]['contact_name'];
    foreach($info as $row){
      $this->attrs[] = $row['attr'];
      $this->values[] = $row['value'];
    }

    if (sizeof($this->attrs) != sizeof($this->values)){
      header('Location: ./fatalerror.php'); exit();
    }
  }

  public function drawCard () {
    $this->getCardInfo();
    $html =
    "<li class=\"chatContactCard\">
        <div class=\"contactCard\">
            <b> {$this->contact_name} </b>
            <table> ";
    for($i = 0; $i < sizeof($this->attrs); $i++){
      $attr = $this->attrs[$i];
      $val = $this->values[$i];
      $html .= "<tr> <th>#{$attr}</th> <td>{$val}</td> </tr>";
    }
    $html .=  " </table>
        </div>
    </li>";
    return $html;
  }
}
