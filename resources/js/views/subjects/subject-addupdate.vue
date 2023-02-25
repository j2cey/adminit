<template>
    <div class="modal fade draggable" id="addUpdateSubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Update Subject</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Create New Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="subjectForm.errors.clear()">

                        <div class="card-body">

                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="title" name="title" autocomplete="title" autofocus placeholder="Title" v-model="subjectForm.title">
                                    <span class="invalid-feedback d-block" role="alert" v-if="subjectForm.errors.has('title')" v-text="subjectForm.errors.get('title')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" autocomplete="description" autofocus placeholder="Description" v-model="subjectForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="subjectForm.errors.has('description')" v-text="subjectForm.errors.get('description')"></span>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="updateSubSubject(subjectParentId)" :disabled="!isValidCreateForm" v-if="editing && isSubsubject">Update SubSubject</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="updateSubject(categoryId)" :disabled="!isValidCreateForm" v-else-if="editing">Update Subject</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="createSubSubject(subjectParentId)" :disabled="!isValidCreateForm" v-else-if="isSubsubject">Create Subsubject</button>
                    <button type="button" class="btn btn-warning btn-sm" @click="createSubject(categoryId)" :disabled="!isValidCreateForm" v-else>Create Subject</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import SubjectBus from './subjectBus'

    class Subject {
        constructor(subject) {
            this.title = subject.title || ''
            this.code = subject.code || ''
            this.description = subject.description || ''
            this.category_id = subject.category_id || ''
            this.category_posi = subject.category_posi || ''
            this.subject_parent_id = subject.subject_parent_id || ''
            this.subsubject_posi = subject.subsubject_posi || ''
        }
    }
    export default {
        name: "subject-addupdate",
        components: { Multiselect },
        mounted() {
            this.$parent.$on('subject_create', (categoryId) => {
                this.editing = false
                this.isSubsubject = false
                this.categoryId = categoryId
                this.subject = new Subject({})
                this.subject.category_id = categoryId
                this.subjectForm = new Form(this.subject)
                $('#addUpdateSubject').modal()
            })
            SubjectBus.$on('subject_edit', (subject) => {
                this.editing = true

                this.isSubsubject = !subject.category_id;
                this.subjectParentId = subject.subject_parent_id ? subject.subject_parent_id : null;
                this.categoryId = subject.category_id ? subject.category_id : null;

                this.subject = new Subject(subject)
                this.subjectForm = new Form(this.subject)
                this.subjectId = subject.uuid
                $('#addUpdateSubject').modal()
            })
            SubjectBus.$on('subsubject_create', (subjectId) => {
                this.editing = false
                this.isSubsubject = true
                this.subjectParentId = subjectId
                this.subject = new Subject({})
                this.subject.subject_parent_id = subjectId
                this.subjectForm = new Form(this.subject)
                $('#addUpdateSubject').modal()
            })
            /*SubjectBus.$on('subsubject_edit', (subject, subjectParentId) => {
                this.editing = true
                this.isSubsubject = true
                this.subject = new SubjectResource(subject)
                this.subject.subject_parent_id = subjectParentId
                this.subjectForm = new Form(this.subject)
                this.subjectId = subject.uuid
                this.subjectParentId = subjectParentId
                $('#addUpdateSubject').modal()
            })*/
        },
        created() {
        },
        data() {
            return {
                subject: {},
                categoryId: '',
                subjectParentId: '',
                subjectForm: new Form(new Subject({})),
                subjectId: null,
                editing: false,
                loading: false,
                isSubsubject: false
            }
        },
        methods: {
            createSubject(categoryId) {
                this.loading = true
                this.subjectForm
                    .post('/subjects')
                    .then(subject => {
                        this.loading = false
                        SubjectBus.$emit('subject_created', {subject, categoryId})
                        $('#addUpdateSubject').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            createSubSubject(subjectParentId) {
                this.loading = true
                this.subjectForm
                    .post('/subsubjects')
                    .then(subject => {
                        this.loading = false
                        SubjectBus.$emit('subsubject_created', {subject, subjectParentId})
                        $('#addUpdateSubject').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateSubject(categoryId) {
                this.loading = true
                this.subjectForm
                    .put(`/subjects/${this.subjectId}`, undefined)
                    .then(subject => {
                        this.loading = false
                        SubjectBus.$emit('subject_updated', {subject, categoryId})
                        $('#addUpdateSubject').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateSubSubject(subjectParentId) {
                this.loading = true
                this.subjectForm
                    .put(`/subsubjects/${this.subjectId}`, undefined)
                    .then(subject => {
                        this.loading = false
                        SubjectBus.$emit('subsubject_updated', {subject, subjectParentId})
                        $('#addUpdateSubject').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
