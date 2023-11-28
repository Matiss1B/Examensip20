<?php
require_once "Db.php";
class Core {
    protected $db;
    public $method;
    protected $allowedMethods;
    public function __construct()
    {
        session_start();
        $this->db = new DB();
//        if($this->checkToken()["status"] !== 200){
//            throw new Exception($this->checkToken()["message"]);
//
//        }
        if($this->checkMethod()["status"] !== 200){
            throw new Exception($this->checkMethod()["message"]);

        }
        if($this->checkMethod()["status"] !== 200){
            throw new Exception($this->checkMethod()["message"]);

        }
//        if(!isset($_SESSION["user_id"])){
//            throw new Exception("Loggin please");
//
//        }

    }
    protected function checkMethod(){
        if(isset($_GET["method"])) {
            if (!in_array($_GET["method"], $this->allowedMethods)) {
                return [
                    "message" => "This method in not allowed!",
                    "status" => 300,
                ];
            }
            $this->method = $_GET["method"];
            return [
                "status" => 200,
            ];
        }else{
            return [
                "message" => "Method is requred in url (?method=....)",
                "status" => 300,
            ];
        }
    }
}