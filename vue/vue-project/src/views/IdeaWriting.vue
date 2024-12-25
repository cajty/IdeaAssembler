<template>
    <div class="container mt-4">

        <TextareaComponent :selectedWork="selectedWork" :idea="idea" @updateText="updateWork" />
        <div class="row">

            <ListGroupComponent :groups="group" :selectedGroup="selectedGroup" @updateGroup="componentsOfGroup" />

            <div class="col-9">
                <div class="row">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="keyListenerSwitch"
                            v-model="keyListenerActive" @change="toggleKeyListener">
                    </div>
                    <WorksComponent :works="works" @updateWork="selectWork" />

                </div>

            </div>
        </div>
        <p v-if="error" class="text-danger">{{ error }}</p>
    </div>
</template>

<script>
import axios from 'axios';
import TextareaComponent from '@/components/TextareaComponent.vue'
import ListGroupComponent from '../components/ListGroupComponent.vue';
import GroupComponent from '../components/GroupComponent.vue';
import WorksComponent from '@/components/WorksComponent.vue'


export default {
    components: {
        TextareaComponent,
        ListGroupComponent,
        WorksComponent,
    },
    emits: ['updateText'],
    data() {
        return {
            idea: {},
            group: {},
            works: {},
            showGroupComponent: false,
            selectedGroup: {},
            selectedWork: '',
            error: null,
            keyListenerActive: false,
        };
    },
    mounted() {
        this.fetchTopic();
        this.fetchIdea();
        window.addEventListener("keydown", this.handleKeyDown);
    },
    beforeDestroy() {
        window.removeEventListener("keydown", this.thatKeyPresed);
    },
    methods: {
        handleKeyDown(event) {
            if (event.key === 'Tab') {
                this.toggleKeyListener();
                event.preventDefault();
            }
        },
        toggleKeyListener() {
            this.keyListenerActive = !this.keyListenerActive;
            if (this.keyListenerActive) {
                window.addEventListener("keydown", this.thatKeyPresed);
            } else {
                window.removeEventListener("keydown", this.thatKeyPresed);
            }
        },
        selectWork(work) {
            this.selectedWork += work + " ";
            console.log(this.selectedWork);
        },
        updateWork(work) {
            this.selectedWork = work;
            console.log(this.selectedWork);
        },
        thatKeyPresed(event) {
            if (event.key === 'ArrowDown') {


                const nextGroupIndex = this.group.findIndex(group => group === this.selectedGroup) + 1;


                if (nextGroupIndex < this.group.length) {

                    this.componentsOfGroup(nextGroupIndex);
                }
            } else if (event.key === 'ArrowUp') {

                const prevGroupIndex = this.group.findIndex(group => group === this.selectedGroup) - 1;

                if (prevGroupIndex >= 0) {

                    this.componentsOfGroup(prevGroupIndex);
                }
            }
            const keyPressed = event.key.toLowerCase();
            if (/^[a-z]$/.test(keyPressed)) {
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
            const letters = 'abcdefghijklmnopqrstuvwxyz'.split('');
            let list = this.group[id].component.map((component, index) => {
                return { ...component, keydown: letters[index] };
            });
            this.selectedGroup = this.group[id];
            this.works = list;
        },
        async fetchTopic() {
            let topicId = this.$route.params.topicId;
            await axios.get(`http://127.0.0.1:8000/api/topics/${topicId}`)

                .then(response => {
                    this.group = response.data.group;
                    this.componentsOfGroup(0);

                })
                .catch(error => {
                    const message = error.response.data.message
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: message,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                });
        },
        async fetchIdea() {
            let ideaId = this.$route.params.ideaId;
            await axios.get(`http://127.0.0.1:8000/api/ideas/${ideaId}`)
                .then(response => {
                    this.idea = response.data;
                    this.selectedWork = this.idea.content;

                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to fetch data';
                });
        }
    },
};
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

.container {
    padding: 20px;
}

.mt-4 {
    margin-top: 1.5rem;
}

.form-check-label {
    font-weight: bold;
    font-size: 1.2rem;
}
</style>
<!-- 
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
}, -->



