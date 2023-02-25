<template>
    <div class="modal fade draggable" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-vertical" @submit.prevent @keydown="priorityForm.errors.clear()">
                        <div class="input-group mb-3">
                            <div class="input">
                                <multiselect
                                    v-model="priorityForm.priority"
                                    selected.sync="priorityForm.priority"
                                    value=""
                                    :options="priorities"
                                    :searchable="true"
                                    :multiple="false"
                                    label="title"
                                    track-by="id"
                                    key="id"
                                    placeholder="Priority"
                                >
                                </multiselect>
                                <span class="invalid-feedback d-block" role="alert" v-if="priorityForm.errors.has('priority')" v-text="priorityForm.errors.get('priority')"></span>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="updatePriority(model_uuid)" :disabled="!isValidCreateForm" v-if="editing"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="createPriority(model_uuid)" :disabled="!isValidCreateForm" v-else><i class="fa fa-check"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    class Priority {
        constructor(priority_obj) {
            this.priority = priority_obj.priority || ''
            this.model_type = priority_obj.model_type || ''
            this.model_id = priority_obj.model_id || ''
            this.posi = priority_obj.posi || ''
        }
    }
    export default {
        name: "priority-addupdate",
        props: {
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: '',
            priority_prop: null
        },
        components: { Multiselect },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.model_type = this.model_type_prop
            this.model_id = this.model_id_prop
            this.model_uuid = this.model_uuid_prop
            this.modal_id = 'addUpdatePriority_' + this.model_uuid
            this.modal_ref = '#addUpdatePriority_' + this.model_uuid
            this.priority = this.priority_prop
        },
        mounted() {
            this.$parent.$on('priority_create', () => {
                this.initPriorityForm()
                $(this.modal_ref).modal()
            })
            this.$parent.$on('priority_edit', () => {
                this.editing = true
                this.priority_obj = new Priority({})
                this.priority_obj.priority = this.priority
                this.priority_obj.model_type = this.model_type
                this.priority_obj.model_id = this.model_id

                this.priorityForm = new Form(this.priority_obj)
                this.priorityId = this.priority.uuid
                $(this.modal_ref).modal()
            })
        },
        created() {
            axios.get('/priorities')
                .then(({data}) => this.priorities = data);

            this.initPriorityForm();
        },
        data() {
            return {
                priority_obj: {},
                priority: {},
                model_id: '',
                model_type: '',
                model_uuid: '',
                modal_id: '',
                modal_ref: '',
                priorityForm: new Form(new Priority({})),
                priorityId: null,
                editing: false,
                loading: false,
                priorities: [],
            }
        },
        methods: {
            initPriorityForm() {
                this.editing = false
                this.priority_obj = new Priority({})
                this.priority_obj.model_type = this.model_type
                this.priority_obj.model_id = this.model_id
                this.priority_obj.priority = null

                this.priorityForm = new Form(this.priority_obj)
            },
            createPriority(modelUuid) {
                this.loading = true
                this.priorityForm
                    .post('/priorities/add')
                    .then(priority => {
                        this.loading = false
                        this.priority = priority
                        this.$parent.$emit('priority_created', { priority, modelUuid })
                        $(this.modal_ref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updatePriority(modelUuid) {
                this.loading = true
                this.priorityForm
                    .put(`/priorities/${this.priorityId}`, undefined)
                    .then(priority => {
                        this.loading = false
                        this.priority = priority
                        this.initPriorityForm()
                        this.$parent.$emit('priority_updated', { priority, modelUuid })
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
