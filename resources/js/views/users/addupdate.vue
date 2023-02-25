<template>
    <div class="modal fade" id="addUpdateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="exampleModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="userForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs text-xs">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Nom" v-model="userForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="userForm.errors.has('name')" v-text="userForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-2 col-form-label text-xs text-xs">Nom utilisateur</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Nom Utilisateur" v-model="userForm.username">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="userForm.errors.has('username')" v-text="userForm.errors.get('username')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label text-xs text-xs">E-mail</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="E-mail" v-model="userForm.email">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="userForm.errors.has('email')" v-text="userForm.errors.get('email')"></span>
                                </div>
                            </div>
                            <div v-if="! editing" class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label text-xs text-xs">Mot de Passe</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="password" name="password" placeholder="Mot de Passe" v-model="userForm.password">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="userForm.errors.has('password')" v-text="userForm.errors.get('password')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_action_type" class="col-sm-2 col-form-label text-xs">User(s)</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_action_type"
                                        v-model="userForm.roles"
                                        selected.sync="user.roles"
                                        value=""
                                        :options="roles"
                                        :searchable="true"
                                        :multiple="true"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Profile(s)"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="userForm.errors.has('roles')" v-text="userForm.errors.get('roles')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="m_select_status" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect
                                        id="m_select_status"
                                        v-model="userForm.status"
                                        selected.sync="user.status"
                                        value=""
                                        :options="statuses"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Statut"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="userForm.errors.has('roles')" v-text="userForm.errors.get('roles')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="updateUser()" :disabled="!isValidForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="createUser()" :disabled="!isValidForm" v-else>Valider</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import UserBus from "./userBus";

    class User {
        constructor(user) {
            this.name = user.name || ''
            this.email = user.email || ''
            this.username = user.username || ''
            this.password = user.password || ''
            this.roles = user.roles || []
            this.status = user.status || {}
        }
    }

    export default {
        name: "user-addupdate",
        props: {
        },
        components: { Multiselect },
        mounted() {
            UserBus.$on('user_create', () => {

                this.editing = false
                this.user = new User({})
                this.userForm = new Form(this.user)

                $('#addUpdateUser').modal()
            })

            UserBus.$on('user_edit', (user) => {
                this.launchEditUser(user)
            })

            this.$parent.$on('user_edit', (user) => {
                this.launchEditUser(user)
            })
        },
        created() {
            axios.get('/roles.fetch')
                .then(({data}) => this.roles = data);
            axios.get('/statuses.fetch')
                .then(({data}) => this.statuses = data);
        },
        data() {
            return {
                formTitle: 'Créer Nouvel Utilisateur',
                user: {},
                userForm: new Form(new User({})),
                userId: null,
                editing: false,
                loading: false,
                roles: [],
                statuses: [],
            }
        },
        methods: {
            createUser() {
                this.loading = true

                this.userForm
                    .post('/users')
                    .then(user => {
                        this.loading = false
                        this.closeModal();

                        this.$swal({
                            html: '<small>Utilisateur créé avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            UserBus.$emit('user_created', user)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            launchEditUser(user) {
                this.editing = true
                this.user = new User(user)
                this.userForm = new Form(this.user)
                this.userId = user.uuid

                this.formTitle = 'Modifier Utilisateur'

                $('#addUpdateUser').modal()
            },
            updateUser() {
                this.loading = true

                this.userForm
                    .put(`/users/${this.userId}`)
                    .then(user => {
                        this.loading = false
                        this.closeModal();

                        this.$swal({
                            html: '<small>Utilisateur Modifié avec succès !</small>',
                            icon: 'success',
                            timer: 3000
                        }).then(() => {
                            UserBus.$emit('user_updated', user)
                        })

                    }).catch(error => {
                    this.loading = false
                });
            },
            closeModal() {
                this.resetForm()
                $('#addUpdateUser').modal('hide')
            },
            resetForm() {
                this.userForm.reset();
            }
        },
        computed: {
            isValidForm() {
                return this.userForm.name && !this.loading
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>
