<html>
    <header>
        <title>Peeps</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("header.php"); ?>

        <div class="scrollContainer">
            <h1> <img src="media/logo.png" id="logoTitle">Peeps</h1>
            <h4> Have you ever forgotten someone's name or other information? Look no further </h4>
            <p> Every day, we meet many people and we re-encounter others we have met before. However, many people have
            difficulty remembering a person’s name, occupation, school, and other attributes. Many of us sometimes find
            ourselves talking to someone who we know we’ve met before, but we don’t remember anything about them. </p>
            <p> Peeps solves this problem by allowing you to create and modify contacts through a fast and intuitive natural
             language system in the form of a chatbot. </p>
            <p> This project takes huge inspiration from <a href="https://helloaugi.com">Augi</a> and <a href="https://todoist.com/">Todoist</a>,
              so please check them out. Peeps is a work-in-progress, and it is meant to serve as a learning exercise for the author.
               Peeps was made by <a href="https://danielemoro.com">Daniele Moro</a> in the Fall of 2018. Here is the <a href="https://github.com/danielemoro/peeps">source code</a>.</p>
            <?php if(!isset($_SESSION['logged_in']) or !$_SESSION['logged_in']) { ?>
            <div class="buttonRow">
                <button onclick="location.href='login.php'">Log In</button>
                <button onclick="location.href='signup.php'" class="buttonHot">Sign Up</button>
            </div>
            <?php } ?>
        </div>

        <?php include_once("footer.php"); ?>
    </body>
</html>
