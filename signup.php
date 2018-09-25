<html>
    <header>
        <title>Peeps - Sign Up</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("templates/header.html"); ?>

        <h1> Sign Up </h1>
        <form method="post" action="index.php">
                <h2> Username </h2>
                <input type="text" name="username" class="formInput">
                <h2> Password </h2>
                <input type="text" name="password" class="formInput">
          <input type="submit" value="Submit" class="formButton">
        </form>

        <?php include_once("templates/footer.html"); ?>
    </body>
</html>
