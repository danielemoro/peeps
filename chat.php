<html>
    <header>
        <title>Peeps - Chat</title>
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
            $userid = 1; // TODO $_SESSION['userid'];
            $messages = $dao->getMessages($userid);
             ?>

            <ul id="messageList">
                <?php
                foreach($messages as $m){
                  $response = $m['from_user'] == 1 ? '' : 'response';
                  if($m['from_user'] == 0 and is_numeric($m['message'])){
                    $card = new ContactCard(41);
                    echo $card->drawCard();
                  } else {
                    echo "<li class=\"message {$response}\">";
                    echo $m['message'];
                    echo '</li>';
                  }
                }
                ?>
                <li class="message space"></li>
            </ul>
        </div>
        <form method="post" class="userInput" action="chat_handler.php">
                <input type="text" name="userInput" class="userTextInput" placeholder="Type your message here">
          <input type="submit" value="Submit" class="userTextSubmit">
        </form>

        <?php include_once("templates/footer.php"); ?>
    </body>
</html>
