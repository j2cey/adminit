<template>
    <div class="modal fade" id="addUpdateDynamicattribute" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="dynamicattributeModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="dynamicattributeForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="dynamicattribute_name" class="col-sm-2 col-form-label text-xs">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="dynamicattribute_name" name="name" autocomplete="name" autofocus placeholder="Name" v-model="dynamicattributeForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="dynamicattributeForm.errors.has('name')" v-text="dynamicattributeForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dynamicattribute_title" class="col-sm-2 col-form-label text-xs">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="dynamicattribute_title" name="title" autocomplete="title" autofocus placeholder="Title" v-model="dynamicattributeForm.title">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="dynamicattributeForm.errors.has('title')" v-text="dynamicattributeForm.errors.get('title')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_dynamicattributetype" class="col-sm-2 col-form-label text-xs">Attribute Type</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect class="text text-xs"
                                                 id="m_select_dynamicattributetype"
                                                 v-model="dynamicattributeForm.dynamicattributetype"
                                                 selected.sync="dynamicattributeForm.dynamicattributetype"
                                                 value=""
                                                 :options="dynamicattributetypes"
                                                 :searchable="true"
                                                 :multiple="false"
                                                 label="name"
                                                 track-by="id"
                                                 key="id"
                                                 placeholder="Attribute Type"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="dynamicattributeForm.errors.has('dynamicattributetype')" v-text="dynamicattributeForm.errors.get('dynamicattributetype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-xs">
                                </label>
                                <div class="col-sm-10">
                                    <b-field label="" label-position="on-border" custom-class="is-small">
                                        <b-checkbox id="searchable" name="searchable" size="is-small" v-model="dynamicattributeForm.searchable"
                                                    type="is-warning" @input="searchableChange($event)">
                                            Searchable
                                        </b-checkbox>
                                        <b-checkbox id="sortable" name="sortable" size="is-small" v-model="dynamicattributeForm.sortable"
                                                    type="is-warning" @input="searchableChange($event)">
                                            Sortable
                                        </b-checkbox>
                                    </b-field>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-xs">
                                </label>
                                <div class="col-sm-10">
                                    <b-field label="" label-position="on-border" custom-class="is-small">
                                        <b-checkbox id="can_be_notified" name="can_be_notified" size="is-small" v-model="dynamicattributeForm.can_be_notified"
                                                    type="is-warning" @input="searchableChange($event)">
                                            Can be Notified
                                        </b-checkbox>
                                    </b-field>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input @keyup.enter="formKeyEnter()" type="text" class="form-control text-xs" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="dynamicattributeForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="dynamicattributeForm.errors.has('description')" v-text="dynamicattributeForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Close</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateDynamicattribute()" :disabled="!isValidCreateForm" v-if="editing">Save</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createDynamicattribute()" :disabled="!isValidCreateForm" v-else>Create Attribute</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    import DynamicattributeBus from "./attributeBus";

    class Dynamicattribute {
        constructor(dynamicattribute) {
            this.name = dynamicattribute.name || ''
            this.title = dynamicattribute.title || ''
            this.dynamicattributetype = dynamicattribute.dynamicattributetype || {}
            this.searchable = dynamicattribute.searchable || false
            this.sortable = dynamicattribute.sortable || false
            this.description = dynamicattribute.description || ''
            this.model_type = dynamicattribute.model_type || ''
            this.model_id = dynamicattribute.model_id || ''
            this.can_be_notified = dynamicattribute.can_be_notified || false
        }
    }
    export default {
        name: "dynamicattribute-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            DynamicattributeBus.$on('create_new_dynamicattribute', ({ model_type, model_id }) => {
                this.editing = false
                this.dynamicattribute = new Dynamicattribute({})
                this.dynamicattributeForm = new Form(this.dynamicattribute)

                this.dynamicattributeForm.model_type = model_type
                this.dynamicattributeForm.model_id = model_id

                this.formTitle = 'Create New Attribute'

                $('#addUpdateDynamicattribute').modal()
            })

            DynamicattributeBus.$on('edit_dynamicattribute', ({ attribute }) => {
                this.editing = true
                this.dynamicattribute = new Dynamicattribute(attribute)
                this.dynamicattributeForm = new Form(this.dynamicattribute)
                this.dynamicattributeId = attribute.uuid

                this.formTitle = 'Edit Attribute'

                $('#addUpdateDynamicattribute').modal()
            })
        },
        created() {
            axios.get('/dynamicattributetypes.fetchall')
                .then(({data}) => this.dynamicattributetypes = data);
        },
        data() {
            return {
                formTitle: 'Create Attribute',
                dynamicattribute: {},
                dynamicattributeForm: new Form(new Dynamicattribute({})),
                dynamicattributeId: null,
                editing: false,
                loading: false,
                dynamicattributetypes: []
            }
        },
        methods: {
            formKeyEnter() {
                if (this.editing) {
                    this.updateDynamicattribute()
                } else {
                    this.createDynamicattribute()
                }
            },
            createDynamicattribute() {
                this.loading = true

                this.dynamicattributeForm
                    .post('/dynamicattributes')
                    .then(newdynamicattribute => {
                        this.loading = false
                        this.$swal({
                            html: '<small>Attribute successfully created !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            DynamicattributeBus.$emit('dynamicattribute_created', newdynamicattribute)
                            $('#addUpdateDynamicattribute').modal('hide')
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },

            searchableChange(event) {
                //this.dynamicattributeForm.dynamicattributetype = event;
                //this.updateDynamicattribute();
            },

            updateDynamicattribute() {
                this.loading = true

                this.dynamicattributeForm
                    .put(`/dynamicattributes/${this.dynamicattributeId}`,undefined)
                    .then(upddynamicattribute => {
                        this.loading = false
                        this.$swal({
                            html: '<small>Attribute successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            DynamicattributeBus.$emit('dynamicattribute_updated', upddynamicattribute)
                            $('#addUpdateDynamicattribute').modal('hide')
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
