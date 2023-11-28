import React, { useEffect, useState } from 'react';
import axios from 'axios';

const List = () => {
    const [data, setData] = useState([]);
    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`http://localhost/exam/Questions.php?method=get`);
                const status = response.data.status;
                const responseData = response.data;
                if (status === 200) {
                    setData(responseData.data);
                }
                if (status === 300) {
                    // Handle status 300
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        };

        fetchData(); // Call the fetchData function

    }, [])

    return (
        <div>
            {data.map((question) => (
                <div key={question.id}>
                    <h2>{question.question}</h2>
                    {question.answers.map((answer) => (
                        <div key={answer.id}>
                            <li>{answer.answer}- {answer.is_true == 1 ? "pareizi": "nepareizi"}</li>

                        </div>
                    ))}
                </div>
            ))}
        </div>
    );
};

export default List;
