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
            <ul id="messageList">
                <li class="message">
                    Yesterday I met @John Smith #at Five Guys #school Boise State #passion Web Dev </li>
                <li class="message response" >
                    Got it! Adding @John Smith
                </li>
                <li class="chatContactCard">
                    <div class="contactCard">
                        <b> John Smith </b>
                        <table>
                            <tr> <th>#at</th> <td>Five Guys</td> </tr>
                            <tr> <th>#school</th> <td>Boise State</td> </tr>
                            <tr> <th>#passion</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                </li>
                <li class="message">
                    Who did I meet #at Julia Davis? </li>
                <li class="message response">
                    You met @John, @Bob, and @Martha at Julia Davis </li>
                <li class="message">
                    @Casey #likes French Butter </li>
                <li class="message response">
                    Got it! I added #likes French Butter to @Casey
                </li>
                <li class="chatContactCard">
                    <div class="contactCard">
                        <b> Casey Kennington </b>
                        <table>
                            <tr> <th>#works</th> <td>Boise State</td> </tr>
                            <tr> <th>#likes</th> <td>French Butter</td> </tr>
                        </table>
                    </div>
                </li>
                <li class="message">
                    @Malik #grader Web Dev </li>
                <li class="message response">
                    Got it! I added #grader Web Dev to @Malik

                </li>
                <li class="chatContactCard">
                    <div class="contactCard">
                        <b> Malik </b>
                        <table>
                            <tr> <th>#grader</th> <td>Web Dev</td> </tr>
                        </table>
                    </div>
                </li>

                <li class="message space"></li>
            </ul>
        </div>
        <form method="post" class="userInput">
                <input type="text" name="userInput" class="userTextInput" value="Type your message here">
          <input type="submit" value="Submit" class="userTextSubmit">
        </form>

        <?php include_once("templates/footer.php"); ?>
    </body>
</html>
