<?php
session_start();

//setting up the time zone
date_default_timezone_set("Asia/Yangon");

class Database {
    private $database;
    private $stm;

    //connect to db
    public function __construct() {

        try {
            $this->database = new PDO("mysql: host=localhost;
                port=3601;  dbname=denlpmm_mzw2018",
                "denlpmm_mzw", "LinkCorp@2018");
            $this->database->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
            $this->database->setAttribute(PDO:: ATTR_DEFAULT_FETCH_MODE, PDO:: FETCH_OBJ);
        }
        catch (PDOException $e){
            throw new Exception($e->getMessage());
        }
    }

    public function query($query) {
        $this->stm = $this->database->prepare($query);
    }

    public function bind($params, $value) {
        // if(is_null($type)) {
        //     switch (true) {
        //         case is_int($value):
        //             $type = PDO:: PARAM_INT;
        //             break;
        //         case is_bool($value):
        //              $type = PDO:: PARAM_BOOL;
        //              break;
        //         case is_null($value):
        //             $type = PDO:: PARAM_NULL;
        //         default:
        //             $type = PDO:: PARAM_STR;
        //             break;
        //     }
        // }
        $this->stm->bindParam($params, $value);
    }

    public function execute() {
        return $this->stm->execute();
    }

    public function resultset() {
        $this->execute();
        return $this->stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function rowCount() {
        $this->execute();
        return $this->stm->rowCount();
    }
}

//Uncomment the two lines below to get error reporting as a dev enviroment.
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
