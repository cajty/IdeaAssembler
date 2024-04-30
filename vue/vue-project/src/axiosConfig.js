import axios from "axios";
import Swal from 'sweetalert2';




const instance = axios.create({
    baseURL: `http://127.0.0.1:8000/api/`, 
    timeout: 10000,
});


instance.interceptors.request.use((config) => {
    const token = localStorage.getItem("token");
    if (token) {
        console.log(token)
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Interceptor to handle response errors
instance.interceptors.response.use(
    (response) => {
        console.log(response)
        if (response.data.message) {
            console.log(response.data.message);
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.data.message,
                showConfirmButton: false,
                timer: 2500,
            });
          
        }else{
            console.log("this is that problem")
        }
        return response.data;
    },
    (error) => {
        console.log(error)
    
        if (error.response) {
            console.log(error);
            if (error.response.status === 401 && localStorage.getItem("token")) {
                localStorage.clear();
                window.location.href = "http://localhost:5174/login";
                if (localStorage.getItem("token")) {

                } else {
                }
            } else if (error.response.status === 403) {
                console.log("you don t have permition to open this route");
            }
        } else if (error.request) {
            console.log("Request error:", error.request);
        } else {
            console.log("Error:", error.message);
        }

        return Promise.reject(error);
    }
);

export default instance;