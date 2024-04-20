
    <template>
        <h1>FOCUS</h1>
        <div class="form-group">
            <label for="category">Topic</label>
            <select class="form-control" id="topic" v-model="topic" @change="emittopic">
                <option v-for="topic in topics" :value="topic.id">{{  topic.topic_name }}</option>
            </select>
        </div>
    </template>

    <script>
import axios from 'axios';
export default {
    data() {
        return {
            topic: null,
            topics: [],
        };
    },

    emits: ['select-topic'],
    methods: {
        emittopic() {
            this.$emit('select-topic', this.topic);
        },
    },

    async created() {
        try {
            const response = await axios.get('http://127.0.0.1:8000/api/user/topics');
            this.topics = response.data;
        } catch (error) {
            console.error(error);
        }
    }


};

</script>

    <style scoped>
        .topic-details {
            padding: 15px;
            border-bottom: 1px solid #000000;
        }
    </style>
