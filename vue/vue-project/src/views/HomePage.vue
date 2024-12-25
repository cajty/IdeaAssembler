<template>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-3">
                <input v-model="topic_name" @input="fetchTopics()" class="form-control" placeholder="Search by name">
            </div>
            <div class="col-md-3 mb-3">
                <CategorySelect @select-category="fetchTopics()"></CategorySelect>
            </div>
            <div class="col-md-3 mb-3">
                <select v-model="filter" @change="fetchTopics()" class="form-select">
                    <option value="all">All time</option>
                    <option value="day">Last day</option>
                    <option value="week">Last week</option>
                    <option value="month">Last month</option>
                    <option value="year">Last year</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <button @click="fetchLikeTopics()" class="btn btn-primary">
                    Like Topics
                </button>
            </div>
        </div>

        <div v-if="topics.length" class="row justify-content-around">
            <div v-for="topic in topics" :key="topic.id" class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ topic.topic_name }}</h5>
                        <p class="card-text">{{ topic.like_count }} likes</p>
                        <p class="card-text">{{ topic.dislike_count }} dislikes</p>
                        <p class="card-text">{{ topic.description.substring(0, 100) }}..</p>
                        <router-link :to="`/topic/${topic.id}`" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Show Topic
                        </router-link>
                        <div class="row justify-content-center mt-3">
                            <div class="col-6 col-md-4 text-center">
                                <i class="material-icons" :class="topic.is_like == 1 ? 'like-icon' : 'neutral-icon'"
                                    @click="like(topic.id)">thumb_up</i>
                                <span class="feedback-count">{{ topic.like_count }}</span>
                            </div>
                            <div class="col-6 col-md-4 text-center">
                                <i class="material-icons" :class="topic.is_like == 0 ? 'dislike-icon' : 'neutral-icon'"
                                    @click="dislike(topic.id)">thumb_down</i>
                                <span class="feedback-count">{{ topic.dislike_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useLikeStore } from '@/stores/likeStore';
import CategorySelect from '@/components/select/CategorySelect.vue';

const { topics, category_id, filter, topic_name } = storeToRefs(useLikeStore());

const fetchTopics = () => {
    useLikeStore().fetchTopics(topic_name.value, category_id.value, filter.value);
};

const fetchLikeTopics = () => {
    useLikeStore().fetchLikeTopics();
};

const like = (topicId) => {
    useLikeStore().like(topicId);
};

const dislike = (topicId) => {
    useLikeStore().dislike(topicId);
};

onMounted(fetchTopics);
</script>

<style scoped>
.material-icons {
    font-size: 1.6rem;
    cursor: pointer;
}

.like-icon {
    color: blue;
}

.dislike-icon {
    color: red;
}

.neutral-icon {
    color: grey;
}

.feedback-count {
    font-size: 0.8rem;
}
</style>