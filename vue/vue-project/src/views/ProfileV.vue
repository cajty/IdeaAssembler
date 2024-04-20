<template>
    <div class="container mt-2 p-3">
        <div class="row">

            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img :src="profile.avatar" alt="Profile avatar" class="rounded-circle mb-3" width="100"
                                height="100">
                            <h5 class="card-title">{{ profile.name }}</h5>
                            <ideaShowForm v-if="showIdeaFrom" @close="close" :idea_id="idea_id"/>
                           <button class="btn btn-black" @click="showIdeaFrom = true" >creat idea </button>
                           <CreatGroup v-if="showGroupCreat" @close="close" @newGroup="newGroup" />

                          

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-between p-1 mt-2">

            <div class="col-md-3 mb-3">

                <UserGroup />

            </div>


            <div class="col-md-6 mb-6">

                <UserIdea @idea-show="ideaShowWirting" />



            </div>


            <div class="col-md-3 mb-3">

                <UserTopic />

            </div>
        </div>
    </div>
</template>

<script>
import UserGroup from '../components/profile/UserGroup.vue'
import UserTopic from '../components/profile/UserTopic.vue'
import UserIdea from '../components/profile/UserIdea.vue'
import TopicSelect from '@/components/select/TopicSelect.vue'
import ideaShowForm from '../components/form/ideaShowForm.vue'
import CreatGroup from '@/components/CreateGroup.vue';




export default {
    components: {
        UserGroup,
        UserTopic,
        UserIdea,
        TopicSelect,
        ideaShowForm,
        CreatGroup
    },
    data() {
        return {
            topic: null,
            idea_id: null,
            title: '',
            showIdeaFrom: false,
            profile: {
                name: 'John Doe',
                bio: 'Software engineer with 5+ years of experience in web development.',
                email: 'john.doe@example.com',
                avatar: 'https://example.com/avatar.jpg',
            },
        };
    },
    methods: {
        selectTopic(topic) {
            this.topic = topic;
        },
        ideaShow() {
           

        },
        close() {
            this.showIdeaFrom = false;
            this.idea_id = null;
        },
     
        ideaShowWirting(idea_id) {
            this.idea_id = idea_id;
            this.showIdeaFrom = true;
        },
    },
};
</script>

<style scoped>
.card {
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.2rem;
}

.mb-3 {
    margin-bottom: 1rem !important;
}
</style>