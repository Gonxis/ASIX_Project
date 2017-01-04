<?php

require_once('dbconfig.php');

class MOVEMENT
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

    public function insert_into_movements()
    {
        try
        {

            $stmt = $this->conn->prepare("INSERT INTO movements(movement_id, movement_date)
		                                               VALUES(NULL, NULL)");

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
            $stmt = $this->conn->prepare("SELECT * FROM movements");

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