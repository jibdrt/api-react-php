

import { useState, useEffect } from "react";
import axios from 'axios';
import { useNavigate, useParams } from "react-router-dom";
export default function ListUser() {
    const navigate = useNavigate();
    const [inputs, setInputs] = useState([]);
    const {id} = useParams();
    useEffect(() => {
        getUser();
    }, []);
}
const handleChange = (event) => {
    const name = event.target.name;
    const value = event.target.value;
    setInputs(values => ({...values, [name]: value}));
}
const handleSubmit = (event) => {
    event.preventDefault();
    axios
        .put(`http://localhost/react-php/api/users/${id}/edit`, inputs)
        .then(function(response) {
            console.log(response.data);
            navigate('/');
        });
}