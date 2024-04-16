<template>
<section class="my-section">
  <div class="my-card">
    <div class="my-card-header">
      <h2><i class="fas fa-heading"></i> {{ topic.topic_name }}</h2>
    </div>
    <div class="my-card-body">
      <p class="my-card-text"><i class="fas fa-align-left"></i> Description: {{ topic.description }}</p>
    </div>
    <div class="my-card-footer">
      <i class="fas fa-thumbs-up"></i> <span class="like-count">{{ topic.like_count }}</span>
      <i class="fas fa-thumbs-down"></i> <span class="dislike-count">{{ topic.dislike_count }}</span>
      <p class="my-card-text"><i class="fas fa-user"></i> Creator ID: {{ topic.creator_id }}</p>
        <button class="btn btn-green" @click="creatGroup" >creat group</button>
    </div>
  </div>
</section>

<CreatGroup v-if="showGroupCreat" @close="close" @newGroup="newGroup" />
        


    <div class="container mt-4">
        <div class="row">
            <ListGroupComponent :groups="group" :selectedGroup="selectedGroup" @updateGroup="componentsOfGroup" />
        </div>
        <p v-if="error" class="text-danger">{{ error }}</p>
        <GroupComponent :Group="selectedGroup" />

    </div>
</template>

<script>
import axios from 'axios';
import ListGroupComponent from '../components/ListGroupComponent.vue';
import GroupComponent from '../components/GroupComponent.vue';
import CreatGroup from '@/components/CreateGroup.vue';

export default {
    components: {
    
        ListGroupComponent,
        GroupComponent,
        CreatGroup,
    },
    data() {
        return {
            topic: {},
            group: {},
            works: {},
            showGroupComponent: false,
            showGroupCreat: false,
            selectedGroup: 0,
            selectedWork: '',
            error: null,
        };
    },
    mounted() {
        this.fetchTopics();
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
        async fetchTopics() {
            const id = this.$route.params.id;
            await axios.get(`http://127.0.0.1:8000/api/topics/${id}`)
                .then(response => {
                    this.topic = response.data;
                    this.group =  this.topic.group;
                    this.componentsOfGroup(0);

                })
                .catch(error => {
                    console.error(error);
                    this.error = 'Failed to fetch data';
                });
        },
        close() {
            this.showGroupCreat = false;
        },
        creatGroup() {
            
            this.showGroupCreat = true;
        },
        async newGroup(group) {
  this.close();
  console.log(group);
  this.group.push(group);
  try {
    const response = await axios.post(`http://127.0.0.1:8000/api/topics/${this.topic.id}/groups/${group.id}`);
    alert(response.data);
  } catch (error) {
    console.error(error);
  }
},

    },
};
</script>
<style >
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
.my-section {
  margin-top: 2rem;
}

.my-card {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
}

.my-card:hover {
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.my-card-header {
  background-color: #007bff;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  color: #ffffff;
  padding: 15px;
}

.my-card-body {
  padding: 20px;
}

.my-card-text {
  margin-bottom: 15px;
}

.my-card-footer {
  background-color: #f8f9fa;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  padding: 15px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.like-count,
.dislike-count {
  margin-left: 5px;
}

@media (max-width: 768px) {
  .my-card-footer {
    flex-direction: column;
  }
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