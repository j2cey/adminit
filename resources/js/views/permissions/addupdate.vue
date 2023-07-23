<template>
    <div class="modal fade" id="addUpdatePermission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="exampleModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" @click="closeModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="permissionForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" autocomplete="name" autofocus placeholder="Titre" v-model="permissionForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="permissionForm.errors.has('name')" v-text="permissionForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="level" class="col-sm-2 col-form-label text-xs">Level</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="level" name="level" autocomplete="level" autofocus placeholder="Level" v-model="permissionForm.level">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="permissionForm.errors.has('level')" v-text="permissionForm.errors.get('level')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="guard_name" class="col-sm-2 col-form-label text-xs">Guard Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="guard_name" name="guard_name" required autocomplete="guard_name" autofocus placeholder="Guard Name" v-model="permissionForm.guard_name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="permissionForm.errors.has('guard_name')" v-text="permissionForm.errors.get('guard_name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="permissionForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="permissionForm.errors.has('description')" v-text="permissionForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Close</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updatePermission()" :disabled="!isValidForm" v-if="editing">Save</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createPermission()" :disabled="!isValidForm" v-else>Create New Permission</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import PermissionBus from "./permissionBus";

class Permission {
    constructor(permission) {
        this.name = permission.name || ''
        this.level = permission.level || ''
        this.guard_name = permission.guard_name || ''
        this.description = permission.description || ''
    }
}
export default {
    name: "permission-addupdate",
    props: {
    },
    components: { },
    mounted() {
        PermissionBus.$on('permission_create', () => {

            this.editing = false
            this.permission = new Permission({})
            this.permissionForm = new Form(this.permission)

            $('#addUpdatePermission').modal()
        })

        PermissionBus.$on('permission_edit', (permission) => {

            this.editing = true
            this.permission = new Permission(permission)
            this.permissionForm = new Form(this.permission)
            this.permissionId = permission.id

            this.formTitle = 'Edit Permission'

            $('#addUpdatePermission').modal()
        })
    },
    created() {

    },
    data() {
        return {
            formTitle: 'Create New Permission',
            permission: {},
            permissionForm: new Form(new Permission({})),
            permissionId: null,
            editing: false,
            loading: false
        }
    },
    methods: {
        createPermission() {
            this.loading = true

            this.permissionForm
                .post('/permissions')
                .then(newpermission => {
                    this.loading = false
                    this.closeModal();

                    this.$swal({
                        html: '<small>Permission créé avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        PermissionBus.$emit('permission_created', newpermission)
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        updatePermission() {
            this.loading = true

            this.permissionForm
                .put(`/permissions/${this.permissionId}`)
                .then(updpermission => {
                    this.loading = false
                    this.closeModal();

                    this.$swal({
                        html: '<small>Permission modifié avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        PermissionBus.$emit('permission_updated', updpermission)
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        closeModal() {
            this.resetForm()
            $('#addUpdatePermission').modal('hide')
        },
        resetForm() {
            this.permissionForm.reset();
        }
    },
    computed: {
        isValidForm() {
            return this.permissionForm.name && !this.loading
        }
    }
}
</script>

<style scoped>

</style>
