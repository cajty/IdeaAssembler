<template>
    <textarea class="form-control textarea mb-3" :value="selectedWork" @input="updateSelectedWork" rows="5"></textarea>
</template>

<script>
export default {
    props: ['selectedWork'],
    methods: {
        updateSelectedWork(event) {
            this.$emit('updateText', event.target.value);
        }
    }
}
</script>