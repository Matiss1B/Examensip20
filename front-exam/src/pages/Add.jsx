import React, {useState} from 'react';
import axios from "axios";
import {useNavigate} from "react-router-dom";
const Add = () => {
    const [question, setQ] = useState("");
    const [answer1, setA1] = useState("");
    const [answer2, setA2] = useState("");
    const [correct, setC] = useState("");
    const navigation = useNavigate();



    const handleQuestion = event =>{
        setQ(event.target.value);
    }
    const handleA1 = event =>{
        setA1(event.target.value);
    }
    const handleA2 = event =>{
        setA2(event.target.value);
    }
    const handleC = event =>{
        setC(event.target.value);
    }
    const handleForm = async () =>{
        const formData = new FormData();
        formData.append("question", question);
        formData.append("answer_1", answer1)
        formData.append("answer_2", answer2);
        formData.append("correct_answer", correct);
        const data ={
            question:question,
            answer_1: answer1,
            answer_2:answer2,
            correct_answer:correct
    }
        try {
            const response = await axios.post(`http://localhost/exam/Questions.php?method=add`, formData);
            console.log(response);
            const status = response.data.status;
            const data = response.data;
            const message = response.data;
            if(status == 200){
                navigation("/list");
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    return (
        <div>
            <p>Jautājums</p>
            <input type="text" id={"question"} onChange={handleQuestion}/>
            <p>1.Atbilde</p>
            <input type="text" id={"question"} onChange={handleA1}/>
            <p>2.Atbilde</p>
            <input type="text" id={"question"} onChange={handleA2}/>
            <p>Pareizā atbilde</p>
            <input type="number" id={"question"} onChange={handleC}/>
            <button onClick={handleForm}>Pievienot</button>
        </div>
    );
};

export default Add;