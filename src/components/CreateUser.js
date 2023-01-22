
import { useState } from "react";
import axios from 'axios';

export default function CreateUser() {
    const [inputs, setInputs] = useState([]);
    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));

    }
    const handleSubmit = (event) => {
        event.preventDefault();
        axios.post('http://localhost:8888/api/user/save', inputs).then(function(response){
            console.log(response.data);
        })
        console.log(inputs);
    }
    return (
        <div>   
            <h1>Create User</h1>
            <form onSubmit={handleSubmit}>
                <table cellSpacing="10">
                    <tbody>
                        <tr>
                            <th>
                                <label>
                                    Name:
                                </label>
                            </th>
                            <td>
                                <input type="text" name="name" onChange={handleChange} />
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label>
                                    Mobile:
                                </label>
                                <input type="text" name="mobile" onChange={handleChange} />
                            </th>
                        </tr>
                        <tr>
                            <td colSpan="2" align="right">
                                <button>Save</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    );
}