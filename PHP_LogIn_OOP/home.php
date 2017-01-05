<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();

    require_once ("class.movement.php");
    $movement_done = new MOVEMENT();

    require_once ("class.led.php");
    $led_action = new LED();
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

    $date = date('Y-m-d H:i:s');

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

        <div class="row" style="margin-top: 150px">

            <div class="col-xs-6 col-md-4"></div>
            <div class="col-xs-6 col-md-4">

                <form action="" method="post">

                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-lamp"></i>
                        <input type="submit" name="turnOn17" value="LUZ" class="btn btn-primary btn-lg btn-block" />
                    </div>
                    <br>
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-lamp"></i>
                        <input type="submit" name="turnOff17" value="Apagar" class="btn btn-danger btn-lg btn-block" />
                    </div>
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

/// Funciones PHP del pin GPIO 17

if (isset($_REQUEST["encender17"])){
    echo $date; // Simplemente pureba a ver si se pulsa un botón y hace lo que toca.
}
if (isset($_POST['turnOn17'])) {
//    $a- exec("sudo python /var/www/leds/gpio/17/enciende.py");
//    echo $a;

    echo $date;
    echo "<br> Luz encendida!";

    // En este caso no hay que insertar nada en la tabla de movimientos, ya que lo que se hace
    // es activar directamente la luz desde la web, sin que el sensor de movimiento lo detecte..
    /*
    $stmt = $movement_done->runQuery("INSERT INTO movements(movement_id, movement_date)
      VALUES(:movement_id, :movement_date)");

    $null = null;
    $stmt->bindparam(":movement_id", $null);
    $stmt->bindparam(":movement_date", date('Y-m-d H:i:s'));

    $stmt->execute();
    */

    // Si el script que hemos hecho sobre el sensor fotosesible detecta que el nivel de luz en el ambiente es
    // mayor que el que se necesita para poder ver algo, no se va a encender la luz led, en caso contrario, se
    // tendría que hacer lo que viene a continuación con tal de no quedarse a oscuras en ningún momento dado.

    $stmt2 = $led_action->runQuery("INSERT INTO led_status(led_id, led_reason, led_status, led_date)
      VALUES(:led_id, :led_reason, :led_status, :led_date)");

    $led_reason = "web";
    $led_status = "on";
    $stmt2->bindparam(":led_id", $null);
    $stmt2->bindparam(":led_reason", $led_reason);
    $stmt2->bindparam(":led_status", $led_status);
    $stmt2->bindparam(":led_date", date('Y-m-d H:i:s'));

    $stmt2->execute();
}

if (isset($_POST['turnOff17'])) {
//    $a- exec("sudo python /var/www/leds/gpio/17/apaga.py");
//    echo $a;

    echo $date;
    echo "<br> Luz apagada..";

    $stmt = $led_action->runQuery("INSERT INTO led_status(led_id, led_reason, led_status, led_date)
          VALUES(:led_id, :led_reason, :led_status, :led_date)");

    $led_reason = "web";
    $led_status = "off";
    $stmt->bindparam(":led_id", $null);
    $stmt->bindparam(":led_reason", $led_reason);
    $stmt->bindparam(":led_status", $led_status);
    $stmt->bindparam(":led_date", date('Y-m-d H:i:s'));

    $stmt->execute();

}

//if ($_POST[parpadear17]) {
//    $a- exec("sudo python /var/www/leds/gpio/17/parpadea.py");
//    echo $a;
//}

//// Fin de las funciones del pin GPIO 17

?>
