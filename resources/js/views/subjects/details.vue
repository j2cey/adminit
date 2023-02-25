<template>
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">

                    <h6 class="profile-username text-center text-sm">{{ subject.title }}</h6>

                    <p class="text-muted text-center text-sm font-weight-light">{{ subject.description }}</p>
                    <p class="text-muted text-center font-italic" v-if="subject.title !== subject.full_path">
                        <small>{{ subject.full_path }}</small>
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item text text-sm" v-if="subject.category">
                            <b>Category</b> <a class="float-right">{{ subject.category.title }}</a>
                        </li>
                        <li class="list-group-item text text-sm" v-else>
                            <b>Subject-Parent</b> <a :href="'/subjects/' + subject.subjectparent.uuid + '' " class="float-right">{{ subject.subjectparent.title }}</a>
                        </li>
                    </ul>

                    <a :href="'/subjects/' + subject.uuid + '/edit' " class="btn btn-primary btn-block btn-sm"><b>Edit</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#tasks" data-toggle="tab">Tasks</a></li>
                        <li class="nav-item"><a class="nav-link" href="#subsubjects" data-toggle="tab">Sub-subject</a></li>
                        <li class="nav-item"><a class="nav-link" href="#planning" data-toggle="tab">Planning</a></li>
                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="tasks">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <span class="badge badge-default">
                                            Tasks of the Subject <span class="badge badge-pill badge-dark">{{subject.tasks.length}}</span>
                                        </span>
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-info float-right" @click="createNewTask(subject.id)"><i class="fas fa-plus"></i> Task</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" id="taskslist">
                                    <!-- Tasks List-->
                                    <tasks-list :tasks_prop="subject.tasks" :parentId_prop="subject.id" :isSubList_prop=false :isUpperListColored_prop=false></tasks-list>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                                        <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="subsubjects">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <span class="badge badge-default">
                                            Sub-Subjects <span class="badge badge-pill badge-dark">{{subject.subsubjects.length}}</span>
                                        </span>
                                    </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-warning float-right" @click="createNewSubsubject(subject.id)"><i class="fas fa-plus"></i> Sub-Subject</button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" id="subsubjectslist">
                                    <!-- Subsubject List-->
                                    <subjects-list :subjects_prop="subject.subsubjects" :parentId_prop="subject.id" :isSubList_prop=true :isUpperListColored_prop=false></subjects-list>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm">
                                        <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                                        <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="planning">

                            <planning></planning>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="timeline">
                            <timeline></timeline>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
        <add-update-task></add-update-task>
        <add-update-subject></add-update-subject>
    </div>
    <!-- /.row -->
</template>

<script>
    import SubjectBus from "./subjectBus";

    import tasksList from '../tasks/tasks-list'
    import addUpdateTask from '../tasks/task-addupdate'

    import subjectsList from '../subjects/subjects-list'
    import addUpdateSubject from '../subjects/subject-addupdate'

    import planning from "./planning";
    import timeline from "./timeline";
    import TaskBus from "../tasks/taskBus";

    export default {
        name: "subject-details",
        props: {
            subject_prop: {}
        },
        components: { tasksList, addUpdateTask, subjectsList, addUpdateSubject, planning, timeline },
        data() {
            return {
                subject: this.subject_prop,
            };
        },
        methods: {
            createNewTask(subjectId) {
                TaskBus.$emit('task_create', subjectId)
            },
            createNewSubsubject(subjectId) {
                SubjectBus.$emit('subsubject_create', subjectId)
            },
        }
    }
</script>

<style scoped>

</style>
