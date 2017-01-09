<?php
session_start();

if (isset($_POST["active"])) {

    require_once("class.led.php");
    $led_action = new LED();

    $date = date('Y-m-d H:i:s');
    $active = $_REQUEST["active"];

    echo $active;

    if ($active == 1) {

        echo $date;

        //    $a- exec("sudo python /var/www/leds/gpio/17/enciende.py");
        //    echo $a;

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

    } elseif ($active == 0) {

        echo $date;

        //    $a- exec("sudo python /var/www/leds/gpio/17/apaga.py");
        //    echo $a;

        $stmt = $led_action->runQuery("INSERT INTO led_status(led_id, led_reason, led_status, led_date)
          VALUES(:led_id, :led_reason, :led_status, :led_date)");

        $led_reason = "web";
        $led_status = "off";
        $stmt->bindparam(":led_id", $null);
        $stmt->bindparam(":led_reason", $led_reason);
        $stmt->bindparam(":led_status", $led_status);
        $stmt->bindparam(":led_date", date('Y-m-d H:i:s'));

        $stmt->execute();

    } else {

        echo "El valor de la variable no corresponde a ningún caso..";

    }

//if ($_POST[parpadear17]) {
//    $a- exec("sudo python /var/www/leds/gpio/17/parpadea.py");
//    echo $a;
//}

    $active = null;

} else {

    echo "Acceso denegado";

}
?>