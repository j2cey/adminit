<template>
    <span>
        <vue-slider v-model="progression.rate" />
        <span v-if="progression.rate === 100" class="badge badge-pill badge-default text-right">Done <i class="fa fa-check text-success"></i></span>
        <span v-else class="badge badge-default text-right">{{progression.rate}}% Realized</span>
    </span>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'

    export default {
        name: "progression-item",
        props: {
            progression_prop: null
        },
        components: { VueSlider },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.progression = this.progression_prop
        },
        mounted() {

        },
        created() {
        },
        data() {
            return {
                progression: null
            }
        }
    }
</script>

<style scoped>

</style>
