<template>
    <div class="info-box">
        <span v-if="execution.progression.rate === 100" class="btn info-box-icon bg-success"><i class="fa fa-check"></i></span>
        <span v-else class="btn info-box-icon bg-info"><i class="fa fa-fast-forward"></i></span>
        <div class="info-box-content">
            <span class="info-box-text"> <grade :grade_prop="execution.grade"></grade> </span>
            <span class="info-box-number"> <duration :duration_prop="execution.duration"></duration> </span>

            <progression :progression_prop="execution.progression"></progression>
            <span class="progress-description">

            </span>

        </div>
    </div>
</template>

<script>
    import grade from '../grades/grade-item'
    import duration from '../durations/duration-item'
    import progression from '../progressions/progression-item'

    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'

    export default {
        name: "execution-item",
        props: {
            execution_prop: null,
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: ''
        },
        components: {
            grade, duration, progression, VueSlider
        },
        data() {
            return {
                execution: this.execution_prop,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop,
                model_uuid: this.model_uuid_prop
            }
        },
        mounted() {
            this.$on('execution_created', (added_data) => {
                if (this.model_uuid === added_data.modelUuid) {
                    this.setDifficulty(added_data.execution)
                }
            })

            this.$on('execution_updated', (upd_data) => {
                if (this.model_uuid === upd_data.modelUuid) {
                    this.setDifficulty(upd_data.execution)
                }
            })
        },
        methods: {
            addDifficulty() {
                this.$emit('execution_create')
            },
            editDifficulty() {
                this.$emit('execution_edit')
            },
            setDifficulty(execution) {
                this.execution = execution
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
