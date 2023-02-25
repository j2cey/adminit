<template>
    <div class="modal fade draggable" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="form-vertical" @submit.prevent @keydown="appreciationForm.errors.clear()">
                        <div class="input-group mb-3">
                            <div class="input">
                                <multiselect
                                    v-model="appreciationForm.appreciation"
                                    selected.sync="appreciationForm.appreciation"
                                    value=""
                                    :options="appreciations"
                                    :searchable="true"
                                    :multiple="false"
                                    label="title"
                                    track-by="id"
                                    key="id"
                                    placeholder="Appreciation"
                                >
                                </multiselect>
                                <span class="invalid-feedback d-block" role="alert" v-if="appreciationForm.errors.has('appreciation')" v-text="appreciationForm.errors.get('appreciation')"></span>
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="updateAppreciation(model_uuid)" :disabled="!isValidCreateForm" v-if="editing"><i class="fa fa-check"></i></button>
                                <button type="button" class="btn btn-warning btn-sm" @click="createAppreciation(model_uuid)" :disabled="!isValidCreateForm" v-else><i class="fa fa-check"></i></button>
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

    class Appreciation {
        constructor(appreciation_obj) {
            this.appreciation = appreciation_obj.appreciation || ''
            this.model_type = appreciation_obj.model_type || ''
            this.model_id = appreciation_obj.model_id || ''
            this.posi = appreciation_obj.posi || ''
        }
    }
    export default {
        name: "appreciation-addupdate",
        props: {
            model_type_prop: '',
            model_id_prop: '',
            model_uuid_prop: '',
            appreciation_prop: null
        },
        components: { Multiselect },
        beforeMount () {
            // save props data to itself's data and deal with it
            this.model_type = this.model_type_prop
            this.model_id = this.model_id_prop
            this.model_uuid = this.model_uuid_prop
            this.modal_id = 'addUpdateAppreciation_' + this.model_uuid
            this.modal_ref = '#addUpdateAppreciation_' + this.model_uuid
            this.appreciation = this.appreciation_prop
        },
        mounted() {
            this.$parent.$on('appreciation_create', () => {
                this.initAppreciationForm()
                $(this.modal_ref).modal()
            })
            this.$parent.$on('appreciation_edit', () => {
                this.editing = true
                this.appreciation_obj = new Appreciation({})
                this.appreciation_obj.appreciation = this.appreciation
                this.appreciation_obj.model_type = this.model_type
                this.appreciation_obj.model_id = this.model_id

                this.appreciationForm = new Form(this.appreciation_obj)
                this.appreciationId = this.appreciation.uuid
                $(this.modal_ref).modal()
            })
        },
        created() {
            axios.get('/appreciations')
                .then(({data}) => this.appreciations = data);

            this.initAppreciationForm();
        },
        data() {
            return {
                appreciation_obj: {},
                appreciation: {},
                model_id: '',
                model_type: '',
                model_uuid: '',
                modal_id: '',
                modal_ref: '',
                appreciationForm: new Form(new Appreciation({})),
                appreciationId: null,
                editing: false,
                loading: false,
                appreciations: [],
            }
        },
        methods: {
            initAppreciationForm() {
                this.editing = false
                this.appreciation_obj = new Appreciation({})
                this.appreciation_obj.model_type = this.model_type
                this.appreciation_obj.model_id = this.model_id
                this.appreciation_obj.appreciation = null

                this.appreciationForm = new Form(this.appreciation_obj)
            },
            createAppreciation(modelUuid) {
                this.loading = true
                this.appreciationForm
                    .post('/appreciations/add')
                    .then(appreciation => {
                        this.loading = false
                        this.appreciation = appreciation
                        this.$parent.$emit('appreciation_created', { appreciation, modelUuid })
                        $(this.modal_ref).modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateAppreciation(modelUuid) {
                this.loading = true
                this.appreciationForm
                    .put(`/appreciations/${this.appreciationId}`, undefined)
                    .then(appreciation => {
                        this.loading = false
                        this.appreciation = appreciation
                        this.initAppreciationForm()
                        this.$parent.$emit('appreciation_updated', { appreciation, modelUuid })
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
