<?php session_start(); ?>

<div id="header">
    <img src="../media/logo.png" id="logo" onclick="location.href='index.php'">
    <ul id="buttonList">
        <a href='index.php'>
          <li class= <?php if($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/')
                            { echo "'headerButton headerButtonHot'"; }
                            else {echo "'headerButton'";} ?> > About </li>
        </a>

        <?php if(isset($_SESSION['logged_in']) and $_SESSION['logged_in']) { ?>
          <a href='chat.php'>
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
      <a href='logout_handler.php'>
        <div id="loginButton"> Welcome <?php echo $_SESSION['user']; ?>! <u>Sign Out</u> </div>
      </a>
    <?php } else { ?>
      <a href='login.php'>
        <div id="loginButton"> Log In </div>
      </a>
    <?php } ?>

</div>
