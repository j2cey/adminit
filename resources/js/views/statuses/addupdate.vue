<template>
    <div class="modal fade" id="addUpdateStatus" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="statusModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="statusForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label text-xs text-xs">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" v-model="statusForm.name" readonly>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="statusForm.errors.has('name')" v-text="statusForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="code" class="col-sm-4 col-form-label text-xs text-xs">Code</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="code" name="code" placeholder="Code" v-model="statusForm.code">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="statusForm.errors.has('code')" v-text="statusForm.errors.get('code')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8 custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input" id="is_default" name="is_default" autocomplete="is_default" autofocus placeholder="Is default ?" v-model="statusForm.is_default">
                                    <label class="custom-control-label" for="is_default"><span class="text text-xs">Is default ?</span></label>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="statusForm.errors.has('is_default')" v-text="statusForm.errors.get('is_default')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-xs text-xs">Description</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Description" v-model="statusForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="statusForm.errors.has('description')" v-text="statusForm.errors.get('description')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateStatus()" :disabled="!isValidForm" v-if="editing">Save</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createStatus()" :disabled="!isValidForm" v-else>Create New Status</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import StatusBus from "./statusBus";

    class Status {
        constructor(status) {
            this.name = status.name || ''
            this.code = status.code || ''
            this.is_default = status.is_default || false
            this.description = status.description || ''
        }
    }

    export default {
        name: "status-addupdate",
        components: { Multiselect },
        mounted() {
            StatusBus.$on('status_edit', (status) => {
                this.editing = true
                this.status = new Status(status)
                this.statusForm = new Form(this.status)
                this.statusId = status.id

                this.formTitle = 'Edit Status'

                $('#addUpdateStatus').modal()
            })
        },
        created() {
            axios.get('/statuses.fetch')
                .then(({data}) => this.groups = data);
        },
        data() {
            return {
                formTitle: 'Create New Status',
                status: {},
                statusForm: new Form(new Status({})),
                statusId: null,
                editing: false,
                loading: false,
                groups: [],
            }
        },
        methods: {
            updateStatus() {
                this.loading = true

                this.statusForm
                    .put(`/statuses/${this.statusId}`)
                    .then(status => {
                        this.loading = false
                        this.resetForm();

                        $('#addUpdateStatus').modal('hide')

                        this.$swal({
                            html: '<small>Status successfully updated !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            StatusBus.$emit('status_updated', status)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateStatus').modal('hide')
            },
            resetForm() {
                this.statusForm.reset();
            }
        },
        computed: {
            isValidForm() {
                return !this.loading
            }
        }
    }
</script>

<style scoped>

</style>
