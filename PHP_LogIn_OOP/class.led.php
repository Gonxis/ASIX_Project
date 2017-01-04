<?php

require_once('dbconfig.php');

class LED
{

    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function turn_led_on()
    {
        try
        {

            $stmt = $this->conn->prepare("INSERT INTO led_status(led_id,led_reason,led_status,led_date)
		                                               VALUES(NULL,'Algo', 'on', NULL)");

            $stmt->execute();

            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function turn_led_off()
    {
        try
        {

            $stmt = $this->conn->prepare("INSERT INTO led_status(led_id,led_reason,led_status,led_date)
		                                               VALUES(NULL,'Algo', 'off', NULL)");

            $stmt->execute();

            return $stmt;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function select_all()
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM led_status");

            return $stmt;
//            $stmt->execute();
//            $movementRow = $stmt->fetch(PDO::FETCH_ASSOC);
//            while ($stmt->rowCount() > 0)
//            {
//                echo $movementRow['movement_id'];
//                echo $movementRow['movement_date'];
//            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
?>