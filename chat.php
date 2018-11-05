<html>
    <header>
        <title>Peeps - Chat</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/contactstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/chatstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="js/chat.js"></script>
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
            $messages = $dao->getMessages($userid);
             ?>

            <ul id="messageList">
                <h2> ... </h2>
                <?php
                foreach($messages as $m){
                  $response = $m['from_user'] == 1 ? '' : 'response';

                  if($m['from_user'] == 0) {
                   if($m['message'] != strip_tags($m['message'])) {
                     echo $m['message'];
                   } else {
                     echo "<li class=\"message {$response}\">";
                     echo $m['message'];
                     echo '</li>';
                   }

                  } else {
                    $sanitizedMessage = filter_var($m['message'], FILTER_SANITIZE_STRING);
                    echo "<li class=\"message {$response}\">";
                    echo $sanitizedMessage;
                    echo '</li>';
                  }
                }
                ?>
                <li class="message space"> </li>
            </ul>
            <a name="bottom"></a>
        </div>
        <form method="post" class="userInput" action="handlers/chat_handler.php" autocomplete="off">
                <input type="text" name="userInput" class="userTextInput" placeholder="Type your message here" autofocus="autofocus" onfocus="this.select()">
          <input type="submit" value="Submit" class="userTextSubmit">
        </form>

        <?php include_once("footer.php"); ?>
    </body>
</html>
