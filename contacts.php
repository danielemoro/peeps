<html>
    <header>
        <title>Peeps - Contact</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/contactstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/chatstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("templates/header.php"); ?>

        <div id="chatFlow">
            <?php
            //make calls to dao
            require_once 'dao.php';
            require_once 'contact_card.php';
            $dao = new Dao();
            $userid = $_SESSION['userid'];
            $contacts = $dao->getContacts($userid);
            ?>

            <ul id="messageList">
                <?php
                foreach($contacts as $c){
                  echo '<li class="contactListItem">';
                  $card = new ContactCard($c[0], $dao, $listclass='contactListItem', $contactDate=True);
                  echo $card->drawCard();
                }
                ?>
                <li class="space"></li>
            </ul>

            <!-- <ul id="messageList">
                <

                <li class="contactListItem">
                    <div class="contactCard">
                        <b> Casey Kennington </b>
                        <table>
                            <tr> <th>#works</th> <td>Boise State</td> </tr>
                            <tr> <th>#likes</th> <td>French Butter</td> </tr>
                        </table>
                    </div>
                    <div class="contactDate">Added 9/10/2018 at 10:30am</div>
                </li>

                <li class="contactListItem">
                    <div class="contactCard">
                        <b> Malik </b>
                        <table>
                            <tr> <th>#grader</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                    <div class="contactDate">Added 9/10/2018 at 10:30am</div>
                </li>

                <li class="contactListItem">
                    <div class="contactCard">
                        <b> Clone McCloney </b>
                        <table>
                            <tr> <th>#works</th> <td>Five Guys</td> </tr>
                            <tr> <th>#school</th> <td>Boise State</td> </tr>
                            <tr> <th>#passion</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                    <div class="contactDate">Added 9/10/2018 at 10:30am</div>
                </li>

                <li class="contactListItem">
                    <div class="contactCard">
                        <b> Clone McCloney </b>
                        <table>
                            <tr> <th>#works</th> <td>Five Guys</td> </tr>
                            <tr> <th>#school</th> <td>Boise State</td> </tr>
                            <tr> <th>#passion</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                    <div class="contactDate">Added 9/10/2018 at 10:30am</div>
                </li>

                <li class="contactListItem">
                    <div class="contactCard">
                        <b> Clone McCloney </b>
                        <table>
                            <tr> <th>#works</th> <td>Five Guys</td> </tr>
                            <tr> <th>#school</th> <td>Boise State</td> </tr>
                            <tr> <th>#passion</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                    <div class="contactDate">Added 9/10/2018 at 10:30am</div>
                </li>

                <li class="contactListItem">
                    <div class="contactCard">
                        <b> Clone McCloney </b>
                        <table>
                            <tr> <th>#works</th> <td>Five Guys</td> </tr>
                            <tr> <th>#school</th> <td>Boise State</td> </tr>
                            <tr> <th>#passion</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                    <div class="contactDate">Added 9/10/2018 at 10:30am</div>
                </li>

                <li class="space"></li>
            </ul> -->
        </div>

        <?php include_once("templates/footer.php"); ?>
    </body>
</html>
