<template>
    <small>
        {{ grade.unit.unit }} <span class="badge badge-info">{{ grade.value }}</span>
    </small>
</template>

<script>
    export default {
        name: "grade-item",
        props: {
            grade_prop: null
        },
        components: { },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.grade = this.grade_prop
        },
        mounted() {
        },
        created() {
        },
        data() {
            return {
                grade: null
            }
        }
    }
</script>

<style scoped>

</style>
