<template>
    <input type="test" v-model="idea.title">
    <textarea class="form-control textarea mb-3" :value="selectedWork" @input="updateSelectedWork" rows="5"></textarea>
    <button @click="saveIdea">save</button>
</template>

<script>
import axios from 'axios';

export default {
    emits: ['updateText'],
    props: {
        selectedWork: {
            type: String,
            required: true
        },
        idea: {
            type: Object,
            required: true
        }
    },
    mounted() {
       
    },
    
    methods: {
        updateSelectedWork(event) {
            this.$emit('updateText', event.target.value);
        },
        async saveIdea() {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/ideas/${this.idea.id}`, {
                    title: this.idea.title,
                    content: this.selectedWork,
                });
                alert('Idea saved');
            } catch (error) {
                console.error(error);
            }
        },
    },
}
</script>