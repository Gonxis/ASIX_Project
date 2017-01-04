<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php">Project Web</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="profile.php">LOG</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="descargarBackUpBBDD.php"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;Download backup BBDD</a></li>
                <li><a href="profile.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;View LOGs</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


    <div class="clearfix"></div>
    	
    
<div class="container-fluid" style="margin-top:80px;">
	
    <div class="container">
    
    	<label class="h5">welcome: <?php print($userRow['user_name']); ?></label>
        <hr />
        
        <h1>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a> &nbsp;
        <a href="profile.php"><span class="glyphicon glyphicon-list-alt"></span> Log</a></h1>
       	<hr />
        
<!--        <p class="h4">User Home Page</p> -->
       
        
    <!--<p class="blockquote-reverse" style="margin-top:200px;">
    Programming Blog Featuring Tutorials on PHP, MySQL, Ajax, jQuery, Web Design and More...<br /><br />
    <a href="http://www.codingcage.com/2015/04/php-login-and-registration-script-with.html">tutorial link</a>
    </p>-->

        <div class="row" style="margin-top: 150px">

            <div class="col-xs-6 col-md-4"></div>
            <div class="col-xs-6 col-md-4">
                <button type="button" name="turnOn17" class="btn btn-primary btn-lg btn-block">
                    <i class="glyphicon glyphicon-lamp"></i> &nbsp; LUZ
                </button>
                <br>
                <form action="" method="post">
                    GPIO 17&nbsp;<input type="submit" name="encender17" value="Encender">
                    <input type="submit" name="apagar17" value="Apagar">
                </form>
            </div>
            <div class="col-xs-6 col-md-4"></div>

        </div>

    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

<?php

//// Funciones PHP del pin GPIO 17
//
//if ($_POST[turnOn17]) {
//    $a- exec("sudo python /var/www/leds/gpio/17/enciende.py");
//    echo $a;
//}
//
//if ($_POST[apagar17]) {
//    $a- exec("sudo python /var/www/leds/gpio/17/apaga.py");
//    echo $a;
//}
//
//if ($_POST[parpadear17]) {
//    $a- exec("sudo python /var/www/leds/gpio/17/parpadea.py");
//    echo $a;
//}
//
//// Fin de las funciónes del pin GPIO 17

?>
