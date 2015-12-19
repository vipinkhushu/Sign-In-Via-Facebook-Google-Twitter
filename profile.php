<?php 
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Welcome <?php  echo $_SESSION['fname']; ?> </title>
        
        <!-- The stylesheets -->
        <link rel="stylesheet" href="assets/css/styles.css" />
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" />
        
        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    
    <body>

    <h1>User Page</h1>
        <div id="main">
      
      <?php if($_SESSION['user_check']):?>
        <div id="avatar" style="background-image:url(<?php echo $_SESSION['dp']?>)"></div>
        <p class="greeting">Welcome, <b><?php echo htmlspecialchars($_SESSION['fullname'])?></b></p>
        <p class="greeting">( <b><?php echo htmlspecialchars($_SESSION['user_check'])?> )</b></p>
              <a href="logout.php" class="logoutButton">Logout</a>

      <?php else:?>
             <?php header("location: index.php");?>
            <?php endif;?>

        </div>
    <p class="note">This Websites Uses The PHP APIS Of <a href="https://developers.facebook.com/docs/reference/php" target="_new">Facebook</a>   And <a href="https://developers.google.com/api-client-library/php/start/get_started" target="_new">Google</a> To Create The Login System.</p>

        <footer>
          <h2><i>Author:</i><a href="http://www.vipinkhushu.com"> Vipin Khushu </a> | RAPL IND.( vipinkhushu[at]hotmail.com )</h2>
            <a class="tzine" href="http://www.github.com/vipinkhushu">Star And Fork This Project <i><b>Github</b></i></a>
        </footer>
        
    </body>
</html>