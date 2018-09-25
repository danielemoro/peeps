<html>
    <header>
        <title>Peeps - Log In</title>
        <link href="styles/style.css" type="text/css" rel="stylesheet" />
        <link href="styles/footerstyle.css" type="text/css" rel="stylesheet" />
        <link href="styles/headerstyle.css" type="text/css" rel="stylesheet" />
    </header>
    <body>
        <?php include_once("templates/header.html"); ?>

        <h1> Log In </h1>
        <form method="post" action="index.php">
                <h2> Username </h2>
                <input type="text" name="name" class="formInput">
                <h2> Password </h2>
                <input type="text" name="comment" class="formInput">
          <input type="submit" value="Submit" class="formButton">
        </form>

        <?php include_once("templates/footer.html"); ?>
    </body>
</html>
