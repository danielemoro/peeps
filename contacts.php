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
        <?php include_once("header.php"); ?>

        <div id="chatFlow">
            <?php
            //make calls to dao
            require_once 'classes/dao.php';
            require_once 'classes/contact_card.php';
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
                if (sizeof($contacts) == 0){
                  echo "<h1> Nothing here yet </h1> <h2> Try adding a contact with @name #attribute description </h2>";
                }
                ?>
                <li class="space"></li>
            </ul>

        </div>

        <?php include_once("footer.php"); ?>
    </body>
</html>
