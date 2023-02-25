<template>
    <small>
        Start at <span class="badge badge-default">{{ duration.start_at | formatDate }}</span>
    </small>
</template>

<script>
    export default {
        name: "duration-item",
        props: {
            duration_prop: null
        },
        components: { },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.duration = this.duration_prop
        },
        mounted() {

        },
        created() {
        },
        data() {
            return {
                duration: null
            }
        }
    }
</script>

<style scoped>

</style>
