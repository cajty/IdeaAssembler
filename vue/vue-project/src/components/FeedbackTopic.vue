<template>
    <div class="row justify-content-center">
        <div class="col-6 col-md-4 text-center">
            <i class="material-icons" :class="topic.Feedback === 1 ? 'like-icon' : 'neutral-icon'"
                @click="dislike(topic.id)">thumb_up</i>
            <span class="feedback-count">{{ topic.Feedback.lenght  }}</span>
        </div>
        <div class="col-6 col-md-4 text-center">
            <i class="material-icons" :class="topic.is_like === 0 ? 'dislike-icon' : 'neutral-icon'"
                @click="like(topic.id)">thumb_down</i>
            <span class="feedback-count"> {{ topic.Feedback.lenght }}</span>
        </div>
    </div>
</template>
<script setup >
import { onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useLikeStore } from '@/stores/likeStore';

 const {topics}  =   storeToRefs(useLikeStore());

onMounted(() => {
     useLikeStore().fetchTopics();
});

</script>
<!-- <script>
import axios from 'axios';
export default {
    props: ['topicId', 'userId', 'likeCount', 'dislikeCount', 'isLiked'],
    data() {
        return {
            is_liked: null,
            like_Count: this.likeCount,
            dislike_Count: this.dislikeCount,
        };
    },
    created() {
        this.is_liked = this.isLiked;
        likeIconClass()
    },
    computed: {
        likeIconClass() {
            return this.is_liked === true ? 'like-icon' : 'neutral-icon';
        },
        dislikeIconClass() {
            return this.is_liked === false ? 'dislike-icon' : 'neutral-icon';
        },
    },
    methods: {
        addLike() {
            axios.post(`http://127.0.0.1:8000/api/like/${this.topicId}/${this.userId}`)
                .then(response => {
                    this.is_liked = response.data;
                })
                .catch(error => {
                    console.error(error);
                });

            if (this.is_liked === true) {
                this.like_Count -= 1;
            } else if (this.is_liked === false) {
                this.like_Count += 1;
                this.dislike_Count -= 1;
            } else {
                this.like_Count += 1;
            }

        },
        addDislike() {
            axios.post(`http://127.0.0.1:8000/api/dislike/${this.topicId}/${this.userId}`)
                .then(response => {
                    this.is_liked = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
            if (this.is_liked === false) {
                this.dislike_Count -= 1;
            } else if (this.is_liked === true) {
                this.likeCount -= 1;
                this.dislike_Count += 1;
            } else {
                this.dislike_Count += 1;
            }
        },
    },
};
</script> -->

<style>
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