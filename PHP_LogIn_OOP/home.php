<?php
require_once("session.php");

require_once("class.user.php");
$auth_user = new USER();

require_once("class.movement.php");
$movement_done = new MOVEMENT();

require_once("class.led.php");
$led_action = new LED();

$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));

$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

// executing the QUERY request to MySQL server, mysql_query() returns resource ID
$stmt2 = $led_action->runQuery('SELECT led_id, led_status FROM led_status ORDER BY led_id DESC LIMIT 1');
$stmt2->execute();
// then we use this resource ID to fetch the actual value MySQL have returned
$lastLedRow = $stmt2->fetch(PDO::FETCH_ASSOC);
// $row variable now holds all the data we got from MySQL, its an array, so we just output the public_id column value to the screen
/*echo "<br><br><br><br><br>";
echo $lastLedRow['led_status'];*/ // you can use var_dump($row); to see the whole content of $row

$date = date('Y-m-d H:i:s');

//$active = 0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <!--<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
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
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>
                        &nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="descargarBackUpBBDD.php"><span class="glyphicon glyphicon-download-alt"></span>&nbsp;Download
                                backup BBDD</a></li>
                        <li><a href="profile.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;View LOGs</a>
                        </li>
                        <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign
                                Out</a></li>
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
        <hr/>

        <h1>
            <a href="home.php"><span class="glyphicon glyphicon-home"></span> Home</a> &nbsp;
            <a href="profile.php"><span class="glyphicon glyphicon-list-alt"></span> Log</a></h1>
        <hr/>

        <div class="row" style="margin-top: 150px">

            <div class="col-xs-4 col-md-4"></div>
            <div class="col-xs-4 col-md-4">

                <form action="" method="post">

                    <div class="text-center">

                        <div class="inner-addon left-addon" id="checkbox_id">
                            <i class="glyphicon glyphicon-lamp"></i>
                            <!-- Rounded switch -->
                            <label class="switch">
                                <input type="checkbox" id="check" name="onoffswitch" class="onoffswitch-checkbox"
                                <?php if($lastLedRow['led_status'] == "on"){echo "checked";} else {echo "";} ?>>
                                <div class="slider round"></div>
                            </label>
                        </div>

                        <br>

                    </div>

                </form>

            </div>
            <div class="col-xs-4 col-md-4"></div>

        </div>

    </div>

</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>

<script type="text/javascript">
    $(document).ready(function () {
        var data;
        $(":checkbox#check").change(function () {
            if ($(":checkbox#check:checked").length == 0) data = 0;
            if ($(":checkbox#check:checked").length) data = 1;
            $.ajax({
                type: 'POST',
                data: ({active: data}),
                url: 'switch.php',
                success: function (response) {
                    //console.log("¡Inserción creada con éxito!");
                    //alert(response);
                }
            });
        });
    });
</script>
