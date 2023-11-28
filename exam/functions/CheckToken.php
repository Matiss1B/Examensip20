<?php
require_once 'inc/Db.php';
class CheckToken {
    private $db;
    public function __construct()
    {
        $this->db = new DB();
    }
    public function checkToken(){
        $auth = apache_request_headers()['Authorization'];
        if(isset($auth)) {
            $token = $this->db->find("tokens", ["token" => $auth]);
            $token_data = $token["data"];
            if ($token["status"] == 200) {
                $date = new DateTime();
                $updated_at = $date->format('Y-m-d H:i:s');
                $timestamp = strtotime($token_data["updated_at"]);
                $currentTimestamp = time();
                $minutesPassed = ($currentTimestamp - $timestamp) / 60;
                if ($minutesPassed >= 15) {
                    $this->db->deleteWhere("tokens", $auth, "token");
                    session_destroy();
                    return [
                        "message" => "Passed",
                        "status" => 422,
                    ];
                }
                if ($this->db->update("tokens", ["updated_at" => $updated_at], $token_data['id'])) {
                    $_SESSION["user_id"] = $token_data['user_id'];
                    return [
                        "status" => 200,
                        "id" => $_SESSION["user_id"],
                    ];
                }
            }
            return [
                "message" => "Unauthorised!",
                "status" => 422,
            ];
        }
        return [
            "message" => "No auth",
            "status" => 422,
        ];
    }
}