<template>

    <div :class="[isUpperListColored ? 'card' : 'card card-info', 'card-outline collapsed-card']">
        <div class="card-header">
            <ul class="nav nav-tabs" :id="'task-'+ task.id +'-tabs-tab'" role="tablist">
                <li class="pt-2 px-3"><span class="card-title d-inline-block text-truncate text-sm-left" style="max-width: 150px;">{{ task.title }}</span></li>

                <li class="nav-item">
                    <a class="nav-link active" :id="'task-tabs-home-tab-' + task.id" data-toggle="pill" :href="'#task-tabs-home-' + task.id" role="tab" aria-controls="task-tabs-home" aria-selected="true"><small>Details</small></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :id="'task-tabs-comments-tab-' + task.id" data-toggle="pill" :href="'#task-tabs-comments-' + task.id" role="tab" aria-controls="task-tabs-comments" aria-selected="false"><small>Comments</small></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :id="'task-tabs-subtasks-tab-' + task.id" data-toggle="pill" :href="'#task-tabs-subtasks-' + task.id" role="tab" aria-controls="task-tabs-subtasks" aria-selected="false"><small>Subtasks <span class="badge badge-pill badge-info">{{ task.subtasks ? task.subtasks.length : 0 }}</span></small></a>
                </li>

            </ul>

            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item text-success" @click="editTask(task)">
                            <small>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                            </small>
                        </a>
                        <a class="dropdown-divider"></a>
                        <a class="dropdown-item text-danger" @click="selectDeleteTask(task)">
                            <small>
                                <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                            </small>
                        </a>
                    </div>
                </div>
                <!-- Maximize Button -->
                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="tab-content" :id="'task-' + task.id + '-tabs-tabContent'">
                <div class="tab-pane fade show active" :id="'task-tabs-home-' + task.id" role="tabpanel" aria-labelledby="task-tabs-home-tab">
                    <dl class="row">
                        <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Title</small></dt>
                        <dd class="col-sm-8"><small class="text-sm-left font-weight-light">{{ task.title }}</small></dd>
                        <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Full Path</small></dt>
                        <dd class="col-sm-8"><small class="text-sm-left font-italic">{{ task.full_path }}</small></dd>
                        <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Description</small></dt>
                        <dd class="col-sm-8"><small class="text-sm-left font-weight-light">{{ task.description }}</small></dd>
                    </dl>
                </div>
                <div class="tab-pane fade" :id="'task-tabs-comments-' + task.id" role="tabpanel" aria-labelledby="task-tabs-comments-tab">

                </div>
                <div class="tab-pane fade" :id="'task-tabs-subtasks-' + task.id" role="tabpanel" aria-labelledby="task-tabs-subtasks-tab">
                    <button type="button" class="btn btn-sm btn-info float-right" @click="addSubTask(task)"><i class="fas fa-plus"></i> Subtask</button>
                    <sub-tasks-list :tasks_prop="task.subtasks" :parentId_prop="task.id" :isSubList_prop=true :isUpperListColored_prop="isCurrentListColored"></sub-tasks-list>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->

</template>

<script>
    import TaskBus from "./taskBus";

    export default {
        name: "task-item",
        props: {
            task_prop: null,
            subtasks_prop: null,
            isSubtask_prop: false,
            isUpperListColored_prop: false
        },
        components: {
            subTasksList: () => import('./tasks-list')
        },
        data() {
            return {
                task: this.task_prop,
                subtasks: this.subtasks_prop,
                isSubtask: this.isSubtask_prop,
                isUpperListColored: this.isUpperListColored_prop,
                isCurrentListColored: !this.isUpperListColored_prop
            }
        },
        mounted() {
            TaskBus.$on('task_updated', (upd_data) => {
                if (this.task.subject_id === upd_data.subjectId && this.task.id === upd_data.task.id) {
                    this.updateTask(upd_data.task)
                }
            })
            TaskBus.$on('subtask_updated', (upd_data) => {
                if (this.task.task_parent_id === upd_data.taskParentId && this.task.id === upd_data.task.id) {
                    console.log('subtask_updated',upd_data)
                    this.updateTask(upd_data.task)
                }
            })
        },
        methods: {
            editTask(task) {
                /*if (this.isSubtask) {
                    TaskBus.$emit('subtask_edit', task, task.task_parent_id)
                } else {
                    TaskBus.$emit('task_edit', task, task.subject_id)
                }*/
                TaskBus.$emit('task_edit', task)
            },
            addSubTask(task) {
                TaskBus.$emit('subtask_create', task.id)
            },
            updateTask(task) {
                window.noty({
                    message: 'Task successfully deleted',
                    type: 'success'
                })
                this.task = task
            },
            selectDeleteTask(task) {
                if (this.isSubtask) {
                    this.deleteSubTask(task);
                } else {
                    this.deleteTask(task);
                }
            },
            deleteTask(task) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/tasks/${task.uuid}`)
                            .then(resp => {
                                this.$parent.$emit('task_deleted', task)
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            },
            deleteSubTask(task) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/subtasks/${task.uuid}`)
                            .then(resp => {
                                this.$parent.$emit('subtask_deleted', task)
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            }
        },
        computed: {

        }
    }
</script>

<style scoped>

</style>
