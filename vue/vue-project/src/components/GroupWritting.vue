<template>
    <div class="container mt-4">
        <textarea class="textarea" v-model="selectedWork" cols="30" rows="10"></textarea>
        <h2>Select a work:</h2>
        <div class="row">
            <div class="col-3" v-for="(work, index) in works" :key="index" @click="selectWork(work.content)">
                <div class="list-group">
                    <div class="list-group-item">
                        {{ work.content }} ({{ work.keydown }})
                    </div>
                </div>
            </div>
        </div>
        <p v-if="error" class="error">{{ error }}</p>
    </div>
</template>

<script>
import axiosInstance from '@/axiosConfig.js';

export default {
    data() {
        return {
            works: [],
            selectedWork: '',
            error: null,
        }
    },
    mounted() {
        this.fetchGroup(1);
        window.addEventListener("keydown", this.handleKeyDown);
    },
    beforeDestroy() {
        window.removeEventListener("keydown", this.handleKeyDown);
    },
    methods: {
        selectWork(work) {
            this.selectedWork += work + " ";
        },
        handleKeyDown(event) {
            const keyPressed = Number(event.key);
            if (/^\d$/.test(keyPressed)) {
                const workObject = this.works.find(work => work.keydown === keyPressed);
                if (workObject) {
                    this.selectedWork += workObject.content + " ";
                    event.preventDefault();
                } else {
                    console.log("No work found");
                }
            }
        },
        async fetchGroup(id) {
            await axiosInstance.get(`groups/${id}`)
                .then(response => {
                    console.log(response.data);
                    this.groupName = response.group;
                    response.data.components = response.data.components.map((component, index) => {
                        return { ...component, keydown: index };
                    });
                    console.log(response.data.components);
                    this.works = response.data.components;
                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to fetch data';
                });
        },
    },
}
</script>

<style scoped>
.container {
    padding: 20px;
}

.textarea {
    width: 100%;
    margin-bottom: 20px;
    font-family: monospace;
}

.list-group-item {
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.error {
    color: red;
    margin-top: 20px;
}
</style>