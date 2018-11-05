<?php session_start();
// create the session
if(!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
    require_once 'classes/contact_card.php';
    require_once 'classes/dao.php';

//if the session created more x seconds ago
} else if(time() - $_SESSION['CREATED'] > 7200) {
    session_destroy();
}

// if the user is not logged in, redirect to home page
if ($_SERVER['REQUEST_URI'] != '/index.php' and
    $_SERVER['REQUEST_URI'] != '/login.php' and
    $_SERVER['REQUEST_URI'] != '/signup.php') {
  if (!isset($_SESSION['logged_in']) or !$_SESSION['logged_in']) {
    header('Location: ./index.php');
    exit;
  }
}
?>

<link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">

<div id="header">
    <img src="../media/logo.png" id="logo" onclick="location.href='index.php'">
    <ul id="buttonList">
        <a href='index.php'>
          <li class= <?php if($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/')
                            { echo "'headerButton headerButtonHot'"; }
                            else {echo "'headerButton'";} ?> > About </li>
        </a>

        <?php if(isset($_SESSION['logged_in']) and $_SESSION['logged_in']) { ?>
          <a href='chat.php '>
            <li class= <?php if($_SERVER['REQUEST_URI'] == '/chat.php')
                              { echo "'headerButton headerButtonHot'"; }
                              else {echo "'headerButton'";} ?> > Chat </li>
          </a>
          <a href='contacts.php'>
            <li class= <?php if($_SERVER['REQUEST_URI'] == '/contacts.php')
                                { echo "'headerButton headerButtonHot'"; }
                                else {echo "'headerButton'";} ?> > Contacts </li>
          </a>
        <?php } ?>

    </ul>

    <?php if(isset($_SESSION['logged_in']) and $_SESSION['logged_in']) { ?>
      <a href='handlers/logout_handler.php'>
        <div id="loginButton"> Welcome <?php echo $_SESSION['username']; ?>! <u>Sign Out</u> </div>
      </a>
    <?php } else { ?>
      <a href='login.php'>
        <div id="loginButton"> Log In </div>
      </a>
    <?php } ?>

</div>
