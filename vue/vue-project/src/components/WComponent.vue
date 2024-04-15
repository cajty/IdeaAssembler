<template>
    <div class="container mt-4">
        <textarea class="form-control textarea mb-3" v-model="selectedWork" rows="5"></textarea>
        <h2>Select a work:</h2>
        <div class="row">
            <div class="col-3 mb-2" v-for="(work, index) in works" :key="index" @click="selectWork(work.content)">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="card-text fs-6">{{ work.keydown }}</p>
                            <p class="card-title fs-6">{{ work.content }}</p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p v-if="error" class="text-danger">{{ error }}</p>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            group : [],
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
        componentsOfGroup(id) {
            let list = this.group[id].component.map((component, index) => {
                        return { ...component, keydown: index + 1 };
                    });
                    this.works = list;
        },
        async fetchGroup(id) {
            await axios.get(`http://127.0.0.1:8000/api/groups/`)
                .then(response => {
                    this.group = response.data;
                    componentsOfGroup(1);

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

.smaller-text {
    font-size: 0.8rem;
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