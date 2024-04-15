<template>
    <div class="container col-8 mt-2 p-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">{{ profile.name }}</h5>
                    </div>
                    <img :src="profile.avatar" alt="Profile avatar" class="rounded-circle" width="100" height="100">
                </div>
            </div>
        </div>
    </div>
    <UserTopic />
    <UserGroup />
    <UserIdea />
</template>

<script>
import UserTopic from '../components/profile/UserTopic.vue'
import UserGroup from '../components/profile/UserGroup.vue'
import UserIdea from '../components/profile/UserIdea.vue'

export default {
    components: {
        UserTopic,
        UserGroup,
        UserIdea
    },
    data() {
        return {
            profile: {
                name: 'John Doe',
                bio: 'Software engineer with 5+ years of experience in web development.',
                email: 'john.doe@example.com',
                avatar: 'https://example.com/avatar.jpg',
            },
        };
    },
};
</script>