User
<template>
    <div>
        <input v-model="userInput" @keydown.enter.prevent="addTags" @keydown.comma.prevent="addTags"
            placeholder="Enter words separated by commas">
        <div class="tags">
            <span v-for="(tag, index) in tags" :key="index" class="tag">
                {{ tag }}
                <button @click="removeTag(index)" class="close-button">&times;</button>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userInput: '',
            tags: []
        };  
    },

    
    methods: {
        addTags() {
            if (this.userInput.trim() !== '' && this.tags.length < 5) {
                const words = this.userInput.split(',').map(word => word.trim());
                words.forEach(word => {
                    if (!this.tags.includes(word) && word !== '' && this.tags.length < 5) {
                        this.tags.push(word);
                    }
                });
                this.userInput = '';
                this.$emit('addTags', this.tags);
            } else {
                alert('You can only create 5 tags.');
            }
        },
        removeTag(index) {
            this.tags.splice(index, 1);
            this.$emit('addTags', this.tags);
        }
    }
};
</script>

<style scoped>
.tag {
    display: inline-block;
    margin-right: 5px;
    margin-bottom: 5px;
    padding: 5px;
    background-color: #f2f2f2;
    border-radius: 3px;
}

.close-button {
    margin-left: 5px;
    cursor: pointer;
    color: #999;
    font-size: 12px;
    border: none;
    background: none;
}
</style>
