

import { useState, useEffect } from "react";
import axios from 'axios';
import { useNavigate, useParams } from "react-router-dom";
export default function ListUser() {
    const navigate = useNavigate();
    const [inputs, setInputs] = useState([]);
    const { id } = useParams();
    useEffect(() => {
        getUser();
    }, []);

    function getUser() {
        axios
            .get(`http://localhost/react-php/api/users.php/${id}`)
            .then(function (response) {
                console.log(response.data);
                setInputs(response.data);
            });
    }

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({ ...values, [name]: value }));
    }
    const handleSubmit = (event) => {
        event.preventDefault();
        axios
            .put(`http://localhost/react-php/api/users/${id}/edit`, inputs)
            .then(function (response) {
                console.log(response.data);
                navigate('/');
            });
    }
    return (
        <div>
            <h1>Edit</h1>
            <form onSubmit={handleSubmit}>
                <div>
                    <label>Name :</label>
                    <input value={inputs.name} type="text" name="name" onChange={handleChange} />
                </div>
                <div>
                    <label>Email :</label>
                    <input value={inputs.email} type="text" name="email" onChange={handleChange} />
                </div>
                <div>
                    <label>Mobile :</label>
                    <input value={inputs.mobile} type="text" name="mobile" onChange={handleChange} />
                </div>
                <div>
                    <button>Save</button>
                </div>
            </form>
        </div>
    )
}