<template>
    <div class="card popup">
        <div class="card-header">
            <button @click="closePopup" class="btn-close float-end" aria-label="Close"></button>
            <h5 class="card-title">{{ idea_id ? 'Edit Idea' : 'Create Idea' }}</h5>
        </div>
        <div class="card-body">
            <form @submit.prevent="showIdea">
                <div class="mb-3" v-if="!idea_id">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" v-model="title" placeholder="Enter title">
                </div>
                <TopicSelect @select-topic="selectTopic" />
                <div class="d-flex justify-content-evenly mt-3">
                    <button type="submit" class="btn btn-success">{{ idea_id ? 'Update Idea' : 'Create Idea' }}</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import TopicSelect from '@/components/select/TopicSelect.vue';


export default {
    components: {
        TopicSelect,
    },
    data() {
        return {
            topic_id: null,
            ideaID: this.idea_id,
            title: '',
            newGroup: {
                name: '',
                components: [{ content: '' }],
            },
        };
    },
    props: {
        idea_id: {
            type: Number,
            default: null
        }

    },






    methods: {
        closePopup() {
            this.$emit('close');
        },
        async creatIdea() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/ideas', {
                    title: this.title,
                    content: "j",
                });
                return response.data.id;
            } catch (error) {
                console.error(error);
            }
        },
        async showIdea() {
            if (this.ideaID == null) {

                this.ideaID = await this.creatIdea();


            }

            this.$router.push({ name: 'IdeaWriting', params: { ideaId: this.ideaID, topicId: this.topic_id } });
        },
        selectTopic(topic_id) {
            this.topic_id = topic_id;
        },


    },
};
</script>
<style scoped>
.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    width: 80%;
    max-width: 450px;
    height: 80%;
    max-height: 450PX;
    padding: 20px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>