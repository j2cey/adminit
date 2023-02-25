<template>
    <div class="modal fade draggable" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Update Execution</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Launch New Execution</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-vertical" @submit.prevent @keydown="executionForm.errors.clear()">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-sm">Grade Unit</label>
                            <div class="col-sm-8">
                                <div class="input">
                                    <multiselect
                                        v-model="executionForm.gradeunit"
                                        selected.sync="executionForm.gradeunit"
                                        value=""
                                        :options="gradeunits"
                                        :searchable="true"
                                        :multiple="false"
                                        label="title"
                                        track-by="id"
                                        key="id"
                                        placeholder="Garde Unit"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block" role="alert" v-if="executionForm.errors.has('gradeunit')" v-text="executionForm.errors.get('gradeunit')"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label :for="'gradevalue_'+model_uuid" class="col-sm-4 col-form-label text-sm">Grade value</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" :id="'gradevalue_'+model_uuid" name="gradevalue" autocomplete="gradevalue" autofocus placeholder="Grade value" v-model="executionForm.gradevalue">
                                <span class="invalid-feedback d-block" role="alert" v-if="executionForm.errors.has('gradevalue')" v-text="executionForm.errors.get('gradevalue')"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label :for="'startat_'+model_uuid" class="col-sm-4 col-form-label text-sm">Start at</label>
                            <div class="col-sm-8">
                                <VueCtkDateTimePicker v-model="executionForm.startat" label="Start at" format="YYYY-MM-DD hh:mm:ss" />
                                <span class="invalid-feedback d-block" role="alert" v-if="executionForm.errors.has('startat')" v-text="executionForm.errors.get('executionForm')"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label v-if="executionForm.execprogression === 100" :for="'execprogression_'+model_uuid" class="col-sm-4 col-form-label text-sm">Execution <span class="badge badge-pill badge-success">Done !</span></label>
                            <label v-else :for="'execprogression_'+model_uuid" class="col-sm-4 col-form-label text-sm">Execution <span class="badge badge-pill badge-warning">{{executionForm.execprogression}}</span></label>
                            <div class="col-sm-8">
                                <vue-slider :id="'execprogression_'+model_uuid" v-model="executionForm.execprogression" />
                                <span class="invalid-feedback d-block" role="alert" v-if="executionForm.errors.has('execprogression')" v-text="executionForm.errors.get('execprogression')"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                    <button type="button" class="btn btn-warning btn-sm" @click="updateExecution(model_uuid)" :disabled="!isValidCreateForm" v-if="editing"> <i class="fa fa-play"></i></button>
                    <button type="button" class="btn btn-warning btn-sm" @click="createExecution(model_uuid)" :disabled="!isValidCreateForm" v-else> <i class="fa fa-play"></i></button>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from "vue-multiselect";
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'

    class Execution {
        constructor(execution_obj) {
            this.gradeunit = execution_obj.gradeunit || ''
            this.gradevalue = execution_obj.gradevalue || 1
            this.startat = execution_obj.startat || ''
            this.execprogression = execution_obj.execprogression || 0
            this.model_type = execution_obj.model_type || ''
            this.model_id = execution_obj.model_id || ''
            this.posi = execution_obj.posi || ''
        }
    }
    export default {
        name: "execution-addupdate",
        props: {
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: '',
            execution_prop: null
        },
        components: { Multiselect, VueSlider },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.model_type = this.model_type_prop
            this.model_id = this.model_id_prop
            this.model_uuid = this.model_uuid_prop
            this.modal_id = 'addUpdateExecution_' + this.model_uuid
            this.modal_ref = '#addUpdateExecution_' + this.model_uuid
            this.execution = this.execution_prop
        },
        mounted() {
            this.$parent.$on('execution_create', () => {
                this.initExecutionForm()
                $(this.modal_ref).modal()
            })
            this.$parent.$on('execution_edit', () => {
                this.editing = true
                this.execution_obj = new Execution({})
                this.execution_obj.execution = this.execution
                this.execution_obj.model_type = this.model_type
                this.execution_obj.model_id = this.model_id

                this.executionForm = new Form(this.execution_obj)
                this.executionId = this.execution.uuid
                $(this.modal_ref).modal()
            })
        },
        created() {
            axios.get('/gradeunits')
                .then(({data}) => this.gradeunits = data);

            this.initExecutionForm();
        },
        data() {
            return {
                value: 0,
                execution_obj: {},
                execution: {},
                model_id: '',
                model_type: '',
                model_uuid: '',
                modal_id: '',
                modal_ref: '',
                executionForm: new Form(new Execution({})),
                executionId: null,
                editing: false,
                loading: false,
                gradeunits: [],
            }
        },
        methods: {
            initExecutionForm() {
                this.editing = false
                this.execution_obj = new Execution({})
                this.execution_obj.model_type = this.model_type
                this.execution_obj.model_id = this.model_id
                this.execution_obj.execution = null

                this.executionForm = new Form(this.execution_obj)
            },
            createExecution(modelUuid) {
                this.loading = true
                this.executionForm
                    .post('/executions/add')
                    .then(execution => {
                        this.loading = false
                        this.execution = execution
                        this.$parent.$emit('execution_created', { execution, modelUuid })
                        $(this.modal_ref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateExecution(modelUuid) {
                this.loading = true
                this.executionForm
                    .put(`/executions/${this.executionId}`, undefined)
                    .then(execution => {
                        this.loading = false
                        this.execution = execution
                        this.initExecutionForm()
                        this.$parent.$emit('execution_updated', { execution, modelUuid })
                        $(this.modal_ref).modal('hide')
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
