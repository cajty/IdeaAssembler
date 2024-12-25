import { defineStore } from "pinia";
import { ref, reactive } from 'vue';
import axios from "axios";

export const useLikeStore = defineStore({
    id: 'likeStore',
    state: () => reactive({
        topics: [],
        filter: null,
        category_id: null,
        topic_name: "",
    }),
    actions: {
        async fetchTopics(topic_name, category_id, filter) {
            const response = await axios.get('http://127.0.0.1:8000/api/search', {
                params: {
                    topic_name,
                    category_id,
                    filter,
                }
            });
            this.category_id = null;
            this.topics = response.data;
        },
        async fetchLikeTopics() {
            const response = await axios.get('http://127.0.0.1:8000/api/userlike/topics',);
            this.topics = response.data;
        },
        async like(id) {
            const response = await axios.post(`http://127.0.0.1:8000/api/like/${id}/1`);
            console.log(response);

            this.topics = this.topics.map((topic) => {
                if(topic.id == response.data.id) return response.data;
                else return topic;
            });
        },
        async dislike(id) {
            const response = await axios.post(`http://127.0.0.1:8000/api/dislike/${id}/1`);
            console.log(response);

            this.topics = this.topics.map((topic) => {
                if(topic.id == response.data.id) return response.data;
                else return topic;
            });
        },

    },
});
