<template>
    <span>
        <a class="btn btn-sm" v-if="priority" @click="editPriority()">
            <span class="badge badge-light">Priority
                <span v-if="priority.level === 0" class="badge badge-pill badge-success">{{priority.title}}</span>
                <span v-else-if="priority.level === 1" class="badge badge-pill badge-info">{{priority.title}}</span>
                <span v-else-if="priority.level === 2" class="badge badge-pill badge-primary">{{priority.title}}</span>
                <span v-else-if="priority.level === 3" class="badge badge-pill badge-warning">{{priority.title}}</span>
                <span v-else class="badge badge-pill badge-danger">{{priority.title}}</span>
            </span>
        </a>
        <a class="btn btn-sm" v-else @click="addPriority()">
            <span class="badge badge-default">Set Priority</span>
        </a>

        <priority-addupdate ref="diffForm" :model_type_prop="model_type" :model_id_prop="model_id" :model_uuid_prop="model_uuid" :priority_prop="priority"></priority-addupdate>
    </span>
</template>

<script>
    import PriorityAddupdate from "./priority-addupdate";

    export default {
        name: "priority-item",
        props: {
            priorities_prop: null,
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: ''
        },
        components: {
            PriorityAddupdate//: () => import('./priority-addupdate'),
        },
        data() {
            return {
                priority: this.priorities_prop ? this.priorities_prop[0] : null,
                model_type: this.model_type_prop,
                model_id: this.model_id_prop,
                model_uuid: this.model_uuid_prop
            }
        },
        mounted() {
            this.$on('priority_created', (added_data) => {
                if (this.model_uuid === added_data.modelUuid) {
                    this.setPriority(added_data.priority)
                }
            })

            this.$on('priority_updated', (upd_data) => {
                if (this.model_uuid === upd_data.modelUuid) {
                    this.setPriority(upd_data.priority)
                }
            })
        },
        methods: {
            addPriority() {
                this.$emit('priority_create')
            },
            editPriority() {
                this.$emit('priority_edit')
            },
            setPriority(priority) {
                this.priority = priority
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
