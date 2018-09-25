<html>
    <header>
        <title>Peeps - Chat</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/chatstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("templates/header.html"); ?>

        <div id="chatFlow">
            <ul id="messageList">
                <li class="message">
                    Yesterday I met @John Smith #at Five Guys #school Boise State #passion Web Dev </li>
                <li class="message response" >
                    Got it! Adding @John Smith</li>
                <li class="message">
                    Who did I meet #at Juilia Davis? </li>
                <li class="message response">
                    You met  </li>
            </ul>
        </div>
        <form method="post" class="userInput">
                <input type="text" name="userInput" class="userTextInput" value="Type your query here">
          <input type="submit" value="Submit" class="userTextSubmit">
        </form>

        <?php include_once("templates/footer.html"); ?>
    </body>
</html>
