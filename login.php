<html>
    <header>
        <title>Peeps - Log In</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("header.php"); ?>

        <h1> Log In </h1>
        <form method="post" action="handlers/login_handler.php">
                <h2> Username </h2>
                <input type="text" name="username" class="formInput"
                      value=<?php if(isset($_SESSION['presets']) and isset($_SESSION['presets']['username'])) {
                          echo $_SESSION['presets']['username'];
                          } else { echo ''; } ?> >
                <h2> Password </h2>
                <input type="password" name="password" class="formInput">
          <input type="submit" value="Submit" class="formButton">
        </form>

        <?php
        if (isset($_SESSION['error_message'])) {
          ?> <div class="errorMessage"> <?=$_SESSION['error_message']?> </div> <?php
          unset($_SESSION['error_message']);
        }
        ?>

        <?php include_once("footer.php"); ?>
    </body>
</html>
