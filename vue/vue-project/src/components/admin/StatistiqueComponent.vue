<template>
    <div class="col-9">
        <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">{{ statistics.users }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Banned Users</h5>
                        <p class="card-text">{{ statistics.bannedUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Topics</h5>
                        <p class="card-text">{{ statistics.topic }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Groups</h5>
                        <p class="card-text">{{ statistics.group }}</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Components</h5>
                        <p class="card-text">{{ statistics.component }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
  
</template>




<script>



import axiosInstance from '@/axiosConfig.js';



export default {
    data() {
        return {
            statistics: {}
        };
    },
    mounted() {
        this.fetchStatistics();
    },
    methods: {
        async fetchStatistics() {
            try {
                const response = await axiosInstance.get('statistic');
                this.statistics = response;
                console.log('Statistics:', this.statistics);
            } catch (error) {
                console.error('Error fetching statistics:', error);
            }
        }
    }
}
</script>
