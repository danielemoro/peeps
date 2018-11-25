<html>
    <header>
        <title>Peeps - Sign Up</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("header.php"); ?>

        <div class="login_signup">
          <h1> Sign Up </h1>
          <form method="post" action="handlers/signup_handler.php">
                  <label for="username">Username</label>
                  <input type="text" name="username" class="formInput"
                        value=<?php if(isset($_SESSION['presets']) and isset($_SESSION['presets']['username'])) {
                            echo $_SESSION['presets']['username'];
                            } else { echo ''; } ?> >
                  <label for="username">Password</label>
                  <input type="password" name="password" class="formInput">
            <input type="submit" value="Submit" class="formButton">
          </form>
        </div>

        <?php
        if (isset($_SESSION['error_message'])) {
          foreach ($_SESSION['error_message'] as $error) {
            ?> <div class="errorMessage"> <?=$error?> </div> <?php
          }
          unset($_SESSION['error_message']);
        }
        ?>

        <?php include_once("footer.php"); ?>
    </body>
</html>
