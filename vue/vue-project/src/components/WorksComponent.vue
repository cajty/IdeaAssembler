<template>
    <div class="col-3 mb-2" v-for="(work, index) in works" :key="index" @click="selectWork(work.content)">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="card-text fs-6">{{ work.keydown }}</p>
                    <p class="card-title fs-6">{{ work.content }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['works'],
    emits: ['updateWork'],
    methods: {
        selectWork(work) {
            this.$emit('updateWork', work);
        },
    },
};
</script>