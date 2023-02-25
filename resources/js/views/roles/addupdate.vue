<template>
    <div class="modal fade" id="addUpdateRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="exampleModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" @click="closeModal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="roleForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" autocomplete="name" autofocus placeholder="Titre" v-model="roleForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="roleForm.errors.has('name')" v-text="roleForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select" class="col-sm-2 col-form-label text-xs">Permission(s)</label>
                                <div class="col-sm-10">
                                    <multiselect
                                        id="m_select"
                                        v-model="roleForm.permissions"
                                        selected.sync="role.permissions"
                                        value=""
                                        :options="permissions"
                                        :searchable="true"
                                        :multiple="true"
                                        label="name"
                                        track-by="name"
                                        key="name"
                                        placeholder="Permission(s)"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="roleForm.errors.has('permissions')" v-text="roleForm.errors.get('permissions')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="roleForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="roleForm.errors.has('description')" v-text="roleForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" @click="closeModal">Fermer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateRole()" :disabled="!isValidForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createRole()" :disabled="!isValidForm" v-else>Créer Profile</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import RoleBus from "./roleBus";

    class Role {
        constructor(role) {
            this.name = role.name || ''
            this.description = role.description || ''
            this.permissions = role.permissions || []
        }
    }
    export default {
        name: "role-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            RoleBus.$on('role_create', () => {

                this.editing = false
                this.role = new Role({})
                this.roleForm = new Form(this.role)

                $('#addUpdateRole').modal()
            })

            RoleBus.$on('role_edit', (role) => {

                this.editing = true
                this.role = new Role(role)
                this.roleForm = new Form(this.role)
                this.roleId = role.id

                this.formTitle = 'Edit Profile'

                $('#addUpdateRole').modal()
            })
        },
        created() {
            axios.get('/permissions')
                .then(({data}) => this.permissions = data);
        },
        data() {
            return {
                formTitle: 'Create New Profile',
                role: {},
                permissions: [],
                roleForm: new Form(new Role({})),
                roleId: null,
                editing: false,
                loading: false
            }
        },
        methods: {
            createRole() {
                this.loading = true

                this.roleForm
                    .post('/roles')
                    .then(newrole => {
                        this.loading = false
                        this.closeModal();

                        this.$swal({
                            html: '<small>Profile créé avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            RoleBus.$emit('role_created', newrole)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            updateRole() {
                this.loading = true

                this.roleForm
                    .put(`/roles/${this.roleId}`)
                    .then(updrole => {
                        this.loading = false
                        this.closeModal();

                        this.$swal({
                            html: '<small>Profile modifié avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            RoleBus.$emit('role_updated', updrole)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateRole').modal('hide')
            },
            resetForm() {
                this.roleForm.reset();
            }
        },
        computed: {
            isValidForm() {
                return this.roleForm.name && !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
