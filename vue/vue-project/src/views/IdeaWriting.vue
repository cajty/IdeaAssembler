<template>
    <div class="container mt-4">
        <TextareaComponent :selectedWork="selectedWork"  @updateWork="updateWork" />
        <div class="row">
        <ListGroupComponent :groups="group" :selectedGroup="selectedGroup"
            @updateGroup="componentsOfGroup" />
        <WorksComponent :works="works" @updateWork="selectWork" />
        </div>
        <p v-if="error" class="text-danger">{{ error }}</p>
      <GroupComponent :Group="selectedGroup"/>

    </div>
</template>

<script>
import axios from 'axios';
import TextareaComponent from '../components/TextareaComponent.vue';
import ListGroupComponent from '../components/ListGroupComponent.vue';
import WorksComponent from '../components/WorksComponent.vue';
import GroupComponent from '../components/GroupComponent.vue';

export default {
    components: {
        TextareaComponent,
        ListGroupComponent,
        WorksComponent,
        GroupComponent,
    },
    data() {
        return {
            group: {},
            works: {},
            showGroupComponent: false,
            selectedGroup: 0,
            selectedWork: '',
            error: null,
        };
    },
    mounted() {
        this.fetchGroup(0);
        window.addEventListener("keydown", this.thatKeyPresed);
    },
    beforeDestroy() {
        window.removeEventListener("keydown", this.thatKeyPresed);
    },
    methods: {
        selectWork(work) {
            this.selectedWork += work + " ";
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
            this.selectedGroup = this.group[id];
            this.works = list;
        },
        async fetchGroup(id) {
            await axios.get(`http://127.0.0.1:8000/api/groups/`)
                .then(response => {
                    this.group = response.data;
                    this.componentsOfGroup(0);

                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to fetch data';
                });
        },
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