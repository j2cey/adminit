<template>
    <div :class="[isUpperListColored ? 'card' : 'card card-warning', 'card-outline collapsed-card']">
        <div class="card-header">
            <small class="card-title d-inline-block text-truncate text-sm-left" style="max-width: 150px;">{{ subject.title }}</small>

            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a class="dropdown-item text-success" :href="'/subjects/' + subject.uuid ">
                            <small>
                                <i class="fa fa-eye" aria-hidden="true"></i> Show
                            </small>
                        </a>
                        <a class="dropdown-item text-primary" @click="editSubject(subject)">
                            <small>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                            </small>
                        </a>
                        <a class="dropdown-divider"></a>
                        <a class="dropdown-item text-danger" @click="selectDeleteSubject(subject)">
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
                    <dd class="col-sm-8"><small class="text-sm-left font-weight-light">{{ subject.title }}</small></dd>
                    <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Full Path</small></dt>
                    <dd class="col-sm-8"><small class="text-sm-left font-italic">{{ subject.full_path }}</small></dd>
                    <dt class="col-sm-4"><small class="text-sm-left font-weight-bold">Description</small></dt>
                    <dd class="col-sm-8"><small class="text-sm-left font-weight-light">{{ subject.description }}</small></dd>
                </dl>
            </div>

            <p>
                <a class="text-info" data-toggle="collapse" :href="'#subject-tabs-tasks-' + subject.id" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="badge badge-info"> <i class="fa fa-tasks" aria-hidden="true"></i> Tasks <span class="badge badge-pill">{{ subject.tasks.length }}</span> </span>
                </a>
                <a class="text-warning" data-toggle="collapse" :href="'#subject-tabs-subsubjects-' + subject.id" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="badge badge-warning"> <i class="fa fa-folder-open" aria-hidden="true"></i> Sub-subjects <span class="badge badge-pill">{{ subject.subsubjects.length }}</span> </span>
                </a>
            </p>

            <div class="collapse" :id="'subject-tabs-tasks-' + subject.id">
                <div class="card card-body">
                    <h6>
                        Tasks <button type="button" class="btn btn-sm" style="background-color:transparent" @click="createNewTask(subject.id)"><i class="fas fa-plus text-info"></i></button>
                    </h6>
                    <tasks-list :tasks_prop="subject.tasks" :parentId_prop="subject.id" :isSubList_prop=false :isUpperListColored_prop=false></tasks-list>
                </div>
            </div>
            <div class="collapse" :id="'subject-tabs-subsubjects-' + subject.id">
                <div class="card card-body">
                    <h6>
                        Sub-subjects <button type="button" class="btn btn-sm" style="background-color:transparent" @click="addSubSubject(subject)"><i class="fas fa-plus text-warning"></i></button>
                    </h6>
                    <sub-subjects-list :subjects_prop="subject.subsubjects" :parentId_prop="subject.id" :isSubList_prop=true :isUpperListColored_prop="isCurrentListColored"></sub-subjects-list>
                </div>
            </div>

        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->
</template>

<script>
    import SubjectBus from "./subjectBus";
    import tasksList from "../tasks/tasks-list";
    import TaskBus from "../tasks/taskBus";

    export default {
        name: "subject-item",
        props: {
            subject_prop: null,
            subsubjects_prop: null,
            isSubsubject_prop: false,
            isUpperListColored_prop: false
        },
        components: {
            subSubjectsList: () => import('./subjects-list'),
            tasksList
        },
        data() {
            return {
                subject: this.subject_prop,
                subsubjects: this.subsubjects_prop,
                isSubsubject: this.isSubsubject_prop,
                isUpperListColored: this.isUpperListColored_prop,
                isCurrentListColored: !this.isUpperListColored_prop
            }
        },
        mounted() {
            SubjectBus.$on('subject_updated', (upd_data) => {
                if (this.subject.category_id === upd_data.categoryId && this.subject.id === upd_data.subject.id) {
                    this.updateSubject(upd_data.subject)
                }
            })
            SubjectBus.$on('subsubject_updated', (upd_data) => {
                if (this.subject.subject_parent_id === upd_data.subjectParentId && this.subject.id === upd_data.subject.id) {
                    this.updateSubject(upd_data.subject)
                }
            })
        },
        methods: {
            createNewTask(subjectId) {
                TaskBus.$emit('task_create', subjectId)
            },
            editSubject(subject) {
                /*if (this.isSubsubject) {
                    SubjectBus.$emit('subsubject_edit', subject, subject.subject_parent_id)
                } else {
                    SubjectBus.$emit('subject_edit', subject, subject.subject_id)
                }*/
                SubjectBus.$emit('subject_edit', subject)
            },
            addSubSubject(subject) {
                SubjectBus.$emit('subsubject_create', subject.id)
            },
            updateSubject(subject) {
                window.noty({
                    message: 'SubjectResource successfully deleted',
                    type: 'success'
                })
                this.subject = subject
            },
            selectDeleteSubject(subject) {
                if (this.isSubsubject) {
                    this.deleteSubSubject(subject);
                } else {
                    this.deleteSubject(subject);
                }
            },
            deleteSubject(subject) {
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

                        axios.delete(`/subjects/${subject.uuid}`)
                            .then(resp => {
                                this.$parent.$emit('subject_deleted', subject)
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    }
                })
            },
            deleteSubSubject(subject) {
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

                        axios.delete(`/subsubjects/${subject.uuid}`)
                            .then(resp => {
                                this.$parent.$emit('subsubject_deleted', subject)
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
