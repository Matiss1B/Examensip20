<?php
require_once "inc/Core.php";
require_once "functions/CheckToken.php";
header("Access-Control-Allow-Origin: http://localhost:3000");

class Questions extends Core {
    private $err_arr = [];
    private $correct_answer;
    private $question_arr = [];
    private $first_answer_arr = [];
    private $second_answer_arr = [];

    protected $allowedMethods = [
        "add",
        "get",
    ];
    public function __construct()
    {
        try {
            parent::__construct();
        } catch (Exception $e) {
            // Handle exceptions if any
            print_r($e->getMessage());
            return;
        }
    }

    public function add(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->question_arr["question"] = $_POST["question"];
            $this->first_answer_arr["answer"] = $_POST["answer_1"];
            $this->second_answer_arr["answer"] = $_POST["answer_2"];
            $this->correct_answer = $_POST["correct_answer"];
            if($this->correct_answer = 1){
                $this->first_answer_arr["is_true"] = 1;
                $this->second_answer_arr["is_true"] = 0;
            }else{
                $this->first_answer_arr["is_true"] = 0;
                $this->second_answer_arr["is_true"] = 1;
            }
            if($this->db->create("questions", $this->question_arr)){
                $lastQ = $this->db->find("questions", ["question"=>$this->question_arr["question"]])["data"];
                $this->first_answer_arr["question_id"] = $lastQ["id"];
                $this->second_answer_arr["question_id"] = $lastQ["id"];
                if($this->db->create("answers", $this->first_answer_arr) && $this->db->create("answers", $this->second_answer_arr)){
                    return json_encode([
                        "message" => "Succesfully done!",
                        "status" => 200,
                    ]);
                }else{
                    return json_encode([
                        "message" => "ERR",
                        "status" => 300,
                    ]);
                }
            }

        }else{
            return json_encode([
                "message" => "This requres method POST",
                "status" => 300,
            ]);
        }
    }
    public function get(){
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->db->getAll("questions");
            $array = [];
            foreach ($this->db->getAll("questions") as $question){
                $answers = $this->db->find("answers", ["question_id"=>$question["id"]]);
                $arr=[];
                $arr["question"] = $question["question"];
                $arr["answers"] = $answers["all_data"];
                array_push($array, $arr);
            }
            return json_encode([
                "data" => $array,
                "status" => 200,
            ]);

        }else{
            return json_encode([
                "message" => "This requres method GET",
                "status" => 300,
            ]);
        }
    }

}
$question = new Questions();
if($question->method == "add") {
    print_r($question->add());
}
if($question->method == "get"){
    print_r($question->get());
}


