<template>

    <div :class="[isUpperListColored ? 'card' : 'card card-info', 'card-outline collapsed-card']">
        <div class="card-header">
            <small class="card-title d-inline-block text-truncate text-sm-left" style="max-width: 150px;">
                {{ task.title }}
            </small>

            <div class="card-tools">
                <!-- Collapse Button -->
                <progression :progression_prop="lastexecution ? lastexecution.progression : null"></progression>
                <appreciation :appreciations_prop="task.appreciations" model_type_prop="App\Models\Task" :model_id_prop="task.id" :model_uuid_prop="task.uuid"></appreciation>
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

            <div>
                <dl class="row">
                    <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Title</small></dt>
                    <dd class="col-sm-8"><small class="text-sm-left font-weight-light">{{ task.title }}</small></dd>
                    <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Full Path</small></dt>
                    <dd class="col-sm-8"><small class="text-sm-left font-italic">{{ task.full_path }}</small></dd>
                    <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Description</small></dt>
                    <dd class="col-sm-8"><small class="text-sm-left font-weight-light">{{ task.description }}</small></dd>
                </dl>
            </div>

            <p>
                <a class="btn btn-app btn-sm" data-toggle="collapse" :href="'#task-tabs-executions-' + task.id" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="badge bg-success">{{ task.executions.length }}</span>
                    <i class="fas fa-terminal"></i> Executions
                </a>
                <a class="btn btn-app btn-sm" data-toggle="collapse" :href="'#task-tabs-comments-' + task.id" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="badge bg-success">{{ task.comments.length }}</span>
                    <i class="fas fa-comments"></i> Comments
                </a>
                <a class="btn btn-app btn-sm" data-toggle="collapse" :href="'#task-tabs-subtasks-' + task.id" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="badge bg-info">{{ task.subtasks.length }}</span>
                    <i class="fa fa-tasks"></i> Subtasks
                </a>

                <priority :priorities_prop="task.priorities" model_type_prop="App\Models\Task" :model_id_prop="task.id" :model_uuid_prop="task.uuid"></priority>
                <difficulty :difficulties_prop="task.difficulties" model_type_prop="App\Models\Task" :model_id_prop="task.id" :model_uuid_prop="task.uuid"></difficulty>
            </p>

            <div class="collapse" :id="'task-tabs-executions-' + task.id">
                <div class="card card-body">
                    <executions-list list_title_prop="Executions" :executions_prop="task.executions" model_type_prop="App\Models\Task" :model_id_prop="task.id" :model_uuid_prop="task.uuid"></executions-list>
                </div>
            </div>
            <div class="collapse" :id="'task-tabs-comments-' + task.id">
                <div class="card card-body">
                    <comments-list :comments_prop="task.comments" model_type_prop="App\Models\Task" :model_id_prop="task.id"></comments-list>
                </div>
            </div>
            <div class="collapse" :id="'task-tabs-subtasks-' + task.id">
                <div class="card card-body">
                    <h6>
                        Subtasks <button type="button" class="btn btn-sm" style="background-color:transparent"  @click="addSubTask(task)"><i class="fas fa-plus text-info"></i></button>
                    </h6>
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
    import difficulty from "../difficulties/difficulty-item"
    import priority from "../priorities/priority-item"
    import appreciation from "../appreciations/appreciation-item"
    import ExecutionsList from "../executions/executions-list";
    import progression from '../progressions/progression-item'

    export default {
        name: "task-item",
        props: {
            task_prop: null,
            subtasks_prop: null,
            isSubtask_prop: false,
            isUpperListColored_prop: false
        },
        components: {
            ExecutionsList,
            subTasksList: () => import('./tasks-list'),
            commentsList: () => import('../comments/comments-list'),
            difficulty,
            priority,
            appreciation,
            progression
        },
        data() {
            return {
                task: this.task_prop,
                lastexecution: this.task_prop ? this.task_prop.executions[0] : null,
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
    .btn-app {
        border-radius: 3px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #6c757d;
        font-size: 12px;
        height: 60px;
        margin: 0 0 10px 10px;
        min-width: 80px;
        padding: 15px 5px;
        position: relative;
        text-align: center;
    }

    .btn-app > .fa,
    .btn-app > .fas,
    .btn-app > .far,
    .btn-app > .fab,
    .btn-app > .glyphicon,
    .btn-app > .ion {
        display: block;
        font-size: 20px;
    }

    .btn-app:hover {
        background: #f8f9fa;
        border-color: #aaaaaa;
        color: #444;
    }

    .btn-app:active, .btn-app:focus {
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    }

    .btn-app > .badge {
        font-size: 10px;
        font-weight: 400;
        position: absolute;
        right: -10px;
        top: -3px;
    }

    .btn-xs {
        padding: 0.125rem 0.25rem;
        font-size: 0.75rem;
        line-height: 1.5;
        border-radius: 0.15rem;
    }
</style>
