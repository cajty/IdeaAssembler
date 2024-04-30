<template>
    <div class="card mt-4 col-8 m-5" id="d">
        <div class="card-body">
            <h2 class="card-title text-center bg-dark text-white">
                User
            </h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index) in users" :key="index">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <button v-if="user.role_id === 2" @click="banedUser(user.id)" class="btn btn-danger">
                                    <i class="fas fa-ban"></i> Ban
                                </button>
                                <button v-if="user.role_id === 3" @click="inbandUser(user.id)" class="btn btn-success">
                                    <i class="fas fa-users"></i> Unban
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination component goes here -->
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: [],
            UserName: '',
        };
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        mapUser(updateUser) {
            this.users = this.users.map((user) => {
                if (user.id == updateUser.id) return updateUser;
                else return user;

            })
        },
        async getUsers() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/getUser');
                this.users = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async banedUser(id) {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/banedUser/${id}`);

                this.mapUser(response.data);
            } catch (error) {
                console.error(error);
            }
        },
        async inbandUser(id) {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/inbanndUser/${id}`);

                this.mapUser(response.data);
            } catch (error) {
                console.error(error);
            }
        },


    },
    created() {
        this.getUsers();
    },
};
</script>