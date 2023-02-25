<template>
    <div class="card-comments">
        <h6>
            {{ list_title }} <button type="button" class="btn btn-sm" style="background-color:transparent"  @click="addExecution()"><i class="fas fa-plus text-info"></i></button>
        </h6>
        <ul class="todo-list" data-widget="todo-list">
            <li class="list-group-item" v-for="(execution, idx) in executions" :key="execution.id">
                <execution-item :execution_prop="execution" :model_type_prop="model_type" :model_id_prop="model_id"></execution-item>
            </li>
        </ul>

        <div>
            <execution-addupdate :model_type_prop="model_type" :model_id_prop="model_id" :model_uuid_prop="model_uuid"></execution-addupdate>
        </div>
    </div>
</template>

<script>
    import ExecutionAddupdate from "./execution-addupdate";
    import ExecutionItem from "./execution-item";

    export default {
        name: "executions-list",
        props: {
            list_title_prop: '',
            executions_prop: null,
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: ''
        },
        components: {
            ExecutionAddupdate, ExecutionItem
        },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.list_title = this.list_title_prop
            this.executions = this.executions_prop
            this.model_type = this.model_type_prop
            this.model_id = this.model_id_prop
            this.model_uuid = this.model_uuid_prop
        },
        data() {
            return {
                list_title: "",
                executions: null,
                model_type: null,
                model_id: null,
                model_uuid: null
            }
        },
        methods: {
            addExecution() {
                this.$emit('execution_create')
            },
            insExecution(execution) {
                let executionIndex = this.executions.findIndex(c => {
                    return execution.id === c.id
                })
                // if this execution does not already exists, it is inserted in the list
                if (executionIndex === -1) {
                    window.noty({
                        message: 'Execution successfully created',
                        type: 'success'
                    })
                    this.executions.push(execution)
                }
            },
            deleteExecution(execution) {
                let executionIndex = this.executions.findIndex(c => {
                    return execution.id === c.id
                })
                // if this execution exists, it is removed from list
                if (executionIndex !== -1) {
                    window.noty({
                        message: 'Execution successfully deleted',
                        type: 'success'
                    })
                    this.executions.splice(executionIndex, 1)
                }
            }
        }
    }
</script>

<style scoped>

</style>
