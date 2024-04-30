<template>
    <div class="container p-5">
        <div class="row justify-content-center">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-8 col-sm-10 border rounded mb-2 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="https://cdn.iconscout.com/icon/premium/png-512-thumb/wallet-2713549-2261381.png"
                                alt="Image" class="img-fluid grayscale-img" />
                        </div>
                        <div class="col-md-6">
                            <h1 class="text-center">Create account</h1>
                            <form @submit.prevent="register">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" v-model="name" id="name" />
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" v-model="email" id="email" />
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" v-model="password" id="password" />
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" value="register"
                                        class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <hr />
                            <p class="text-center">Already have an account? <router-link to="/login">Login</router-link>
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import axiosInstance from'@/axiosConfig.js';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
        };
    },
    methods: {
        validateRegister() {
            if (this.name === '' || this.email === '' || this.password === '') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please fill in all fields',
                    showConfirmButton: false,
                    timer: 1500,
                });
                return;
            }
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(this.email)) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please enter a valid email address',
                    showConfirmButton: false,
                    timer: 1500,
                });
                return false;
            }

            // Validate password length
            if (this.password.length < 8) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Password must be at least 8 characters long',
                    showConfirmButton: false,
                    timer: 1500,
                });
                return false;
            }


        },
        register() {
            this.validateRegister();
            axiosInstance.post('register', {
                name: this.name,
                email: this.email,
                password: this.password,

            }).then(response => {

                    this.$router.push({ name: 'login' });
                    

                })
                .catch(error => {
                    const message = error.response.data.error
                    console.log(message);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'everb',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                })
        },
    },
};
</script>

<style scoped>
/* Add any necessary styling here */
</style>