<template>
    <div class="card">
        <ul class="todo-list" data-widget="todo-list">

            <li class="list-group-item"
                v-for="(task, idx) in tasks"
                :key="task.id"
            >
                <i class="fa fa-align-justify handle"></i>

                <taskitem :task_prop="task" :subtasks_prop="task.subtasks" :is-subtask_prop="isSubList" :is-upper-list-colored_prop="isUpperListColored"></taskitem>

            </li>

        </ul>
    </div>
</template>

<script>
    import TaskBus from './taskBus'
    import taskitem from "./task-item";

    export default {
        name: "tasks-list",
        props: {
            tasks_prop: {},
            parentId_prop: '',
            isSubList_prop: false,
            isUpperListColored_prop: false
        },
        components: { taskitem },
        mounted() {
            TaskBus.$on('task_created', (add_data) => {
                if (this.parentId === add_data.subjectId && !this.isSubList) {
                    this.addTask(add_data.task)
                }
            })
            TaskBus.$on('subtask_created', (add_data) => {
                if (this.parentId === add_data.taskParentId && this.isSubList) {
                    this.addTask(add_data.task)
                }
            })

            this.$on('task_deleted', (task) => {
                this.deleteTask(task);
            })
            this.$on('subtask_deleted', (task) => {
                this.deleteTask(task);
            })
        },
        data() {
            return {
                tasks: this.tasks_prop,
                parentId: this.parentId_prop,
                isSubList: this.isSubList_prop,
                isUpperListColored: this.isUpperListColored_prop
            }
        },
        methods: {
            editTask(task) {
                TaskBus.$emit('task_edit', task, task.subject_id)
            },
            addSubTask(taskId) {
                TaskBus.$emit('subtask_create', taskId)
            },
            updateTask(task) {
                // we get the index of the modified task
                let taskIndex = this.tasks.findIndex(s => {
                    return task.id === s.id
                })
                this.tasks.splice(taskIndex, 1, task)
                window.noty({
                    message: 'Task successfully modified',
                    type: 'success'
                })
            },
            addTask(task) {
                let taskIndex = this.tasks.findIndex(c => {
                    return task.id === c.id
                })
                // if this task does not already exists, it is inserted in the list
                if (taskIndex === -1) {
                    window.noty({
                        message: 'Task successfully created',
                        type: 'success'
                    })
                    this.tasks.push(task)
                }
            },
            deleteTask(task) {
                let taskIndex = this.tasks.findIndex(c => {
                    return task.id === c.id
                })
                // if this task exists, it is removed from list
                if (taskIndex !== -1) {
                    window.noty({
                        message: 'Task successfully deleted',
                        type: 'success'
                    })
                    this.tasks.splice(taskIndex, 1)
                }
            }
        }
    }
</script>

<style scoped>

</style>
