<template>
    <div class="modal fade" id="addUpdateAnalysisrule" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="analysisruleModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="analysisruleForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="analysisrule_title" class="col-sm-2 col-form-label text-xs">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="analysisrule_title" name="title" autocomplete="title" autofocus placeholder="Titre" v-model="analysisruleForm.title">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="analysisruleForm.errors.has('title')" v-text="analysisruleForm.errors.get('title')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4">
                                    <input type="checkbox" class="custom-control-input" id="alert_when_allowed" name="alert_when_allowed" autocomplete="alert_when_allowed" v-model="analysisruleForm.alert_when_allowed">
                                    <label class="custom-control-label" for="alert_when_allowed"><span class="text text-xs">Alert when Allowed</span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="analysisruleForm.errors.has('alert_when_allowed')" v-text="analysisruleForm.errors.get('alert_when_allowed')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-4">
                                    <input type="checkbox" class="custom-control-input" id="alert_when_broken" name="alert_when_broken" autocomplete="alert_when_broken" v-model="analysisruleForm.alert_when_broken">
                                    <label class="custom-control-label" for="alert_when_broken"><span class="text text-xs">Alert when Broken</span></label>
                                    <span class=" invalid-feedback d-block text-xs" role="alert" v-if="analysisruleForm.errors.has('alert_when_broken')" v-text="analysisruleForm.errors.get('alert_when_broken')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_analysisruletype" class="col-sm-2 col-form-label text-xs">Analysisrule Type</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect class="text text-xs"
                                                 id="m_select_analysisruletype"
                                                 v-model="analysisruleForm.analysisruletype"
                                                 selected.sync="analysisruleForm.analysisruletype"
                                                 value=""
                                                 :options="analysisruletypes"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="name"
                                                 track-by="id"
                                                 key="id"
                                                 placeholder="Analysisrule Type"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="analysisruleForm.errors.has('analysisruletype')" v-text="analysisruleForm.errors.get('analysisruletype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="analysisrule_description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input @keyup.enter="formKeyEnterDown()" type="text" class="form-control text-xs" id="analysisrule_description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="analysisruleForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="analysisruleForm.errors.has('description')" v-text="analysisruleForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Close</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateAnalysisrule()" :disabled="!isValidCreateForm" v-if="editing">Save</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createAnalysisrule()" :disabled="!isValidCreateForm" v-else>Create Analysisrule</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    import AnalysisruleBus from "./analysisruleBus";

    class Analysisrule {
        constructor(analysisrule) {
            this.title = analysisrule.title || ''
            this.alert_when_allowed = analysisrule.alert_when_allowed || ''
            this.alert_when_broken = analysisrule.alert_when_broken || ''
            this.analysisruletype = analysisrule.analysisruletype || ''
            this.description = analysisrule.description || ''
            this.dynamic_attribute_id = analysisrule.dynamic_attribute_id || ''
        }
    }
    export default {
        name: "analysisrule-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            AnalysisruleBus.$on('create_new_analysisrule', ({ attribute }) => {

                console.log('create_new_analysisrule received: ', attribute)

                this.editing = false
                this.analysisrule = new Analysisrule({})
                this.analysisruleForm = new Form(this.analysisrule)

                this.analysisruleForm.dynamic_attribute_id = attribute.id

                this.formTitle = 'Create New Analysis Rule'

                $('#addUpdateAnalysisrule').modal()
            })

            AnalysisruleBus.$on('edit_analysisrule', ({ analysisrule }) => {
                this.editing = true
                this.analysisrule = new Analysisrule(analysisrule)
                this.analysisruleForm = new Form(this.analysisrule)
                this.analysisruleId = analysisrule.uuid

                this.formTitle = 'Edit Analysis Rule'

                $('#addUpdateAnalysisrule').modal()
            })
        },
        created() {
            axios.get('/analysisruletypes.fetchall')
                .then(({data}) => this.analysisruletypes = data);
        },
        data() {
            return {
                formTitle: 'Create Analysisrule',
                analysisrule: {},
                analysisruleForm: new Form(new Analysisrule({})),
                analysisruleId: null,
                editing: false,
                loading: false,
                analysisruletypes: []
            }
        },
        methods: {
            formKeyEnterDown() {
                if (this.editing) {
                    this.updateAnalysisrule()
                } else {
                    this.createAnalysisrule()
                }
            },
            createAnalysisrule() {
                this.loading = true

                this.analysisruleForm
                    .post('/analysisrules')
                    .then(analysisrule => {
                        this.loading = false

                        this.$swal({
                            html: '<small>Analysis Rule successfully created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            AnalysisruleBus.$emit('analysisrule_created', analysisrule)
                            $('#addUpdateAnalysisrule').modal('hide')
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            updateAnalysisrule() {
                this.loading = true

                this.analysisruleForm
                    .put(`/analysisrules/${this.analysisruleId}`,undefined)
                    .then(analysisrule => {
                        this.loading = false

                        this.$swal({
                            html: '<small>Analysis Rule successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            AnalysisruleBus.$emit('analysisrule_updated', analysisrule)
                            $('#addUpdateAnalysisrule').modal('hide')
                        })

                    }).catch(error => {
                    this.loading = false
                });
            }
        },
        computed: {
            isValidCreateForm() {
                return !this.loading
            }
        }
    }
</script>
