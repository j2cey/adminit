<template>
    <div class="modal fade" id="addUpdateAccessaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="accessaccountModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="accessaccountForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="accessaccount_username" class="col-sm-2 col-form-label text-xs">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="accessaccount_username" name="username" autocomplete="username" autofocus placeholder="Username" v-model="accessaccountForm.username">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessaccountForm.errors.has('username')" v-text="accessaccountForm.errors.get('username')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="accessaccount_login" class="col-sm-2 col-form-label text-xs">Login</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="accessaccount_login" name="login" autocomplete="login" autofocus placeholder="Login" v-model="accessaccountForm.login">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessaccountForm.errors.has('login')" v-text="accessaccountForm.errors.get('login')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="accessaccount_pwd" class="col-sm-2 col-form-label text-xs">Mot de Passe</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="accessaccount_pwd" name="pwd" autocomplete="pwd" autofocus placeholder="Mot de Passe" v-model="accessaccountForm.pwd">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessaccountForm.errors.has('pwd')" v-text="accessaccountForm.errors.get('pwd')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="accessaccount_email" class="col-sm-2 col-form-label text-xs">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="accessaccount_email" name="email" autocomplete="email" autofocus placeholder="Email" v-model="accessaccountForm.email">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessaccountForm.errors.has('email')" v-text="accessaccountForm.errors.get('email')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10">
                                    <b-field label="Statut" label-position="on-border" custom-class="is-small">
                                        <b-radio-button size="is-small" v-model="accessaccountForm.status"
                                                        native-value="active"
                                                        type="is-success is-light is-outlined">
                                            <b-icon icon="check"></b-icon>
                                            <span>Actif</span>
                                        </b-radio-button>
                                        <b-radio-button size="is-small" v-model="accessaccountForm.status"
                                                        native-value="inactive"
                                                        type="is-danger is-light is-outlined">
                                            <b-icon icon="close"></b-icon>
                                            <span>Inactif</span>
                                        </b-radio-button>
                                    </b-field>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input @keyup.enter="formKeyEnter()" type="text" class="form-control text-xs" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="accessaccountForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessaccountForm.errors.has('description')" v-text="accessaccountForm.errors.get('description')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateAccessaccount()" :disabled="!isValidCreateForm" v-if="editing">Enregister</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createAccessaccount()" :disabled="!isValidCreateForm" v-else>Créer le Compte</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

import AccessAccountBus from "./accessaccountBus";

class Accessaccount {
    constructor(accessaccount) {
        this.username = accessaccount.username || ''
        this.login = accessaccount.login || ''
        this.pwd = accessaccount.pwd || ''
        this.email = accessaccount.email || ''
        this.description = accessaccount.description || ''

        this.status = accessaccount.status ? accessaccount.status.code : 'active'
    }
}
export default {
    name: "accessaccount-addupdate",
    props: {
    },
    components: {  },
    mounted() {

        AccessAccountBus.$on('create_new_accessaccount', () => {
            this.editing = false
            this.accessaccount = new Accessaccount({})
            this.accessaccountForm = new Form(this.accessaccount)

            this.formTitle = 'Créer un nouveau Compte'

            $('#addUpdateAccessaccount').modal()
        })

        AccessAccountBus.$on('edit_accessaccount', ({ accessaccount }) => {
            this.editing = true
            this.accessaccount = new Accessaccount(accessaccount)
            this.accessaccountForm = new Form(this.accessaccount)
            this.accessaccountId = accessaccount.uuid

            this.formTitle = 'Modification du Compte'

            $('#addUpdateAccessaccount').modal()
        })
    },
    created() {
    },
    data() {
        return {
            formTitle: 'Créer un nouveau Compte',
            accessaccount: {},
            accessaccountForm: new Form(new Accessaccount({})),
            accessaccountId: null,
            editing: false,
            loading: false,
        }
    },
    methods: {
        formKeyEnter() {
            if (this.editing) {
                this.updateAccessaccount()
            } else {
                this.createAccessaccount()
            }
        },
        createAccessaccount() {
            this.loading = true

            this.revertStatusObject()

            this.accessaccountForm
                .post('/accessaccounts')
                .then(newaccessaccount => {
                    this.loading = false
                    this.$swal({
                        html: '<small>Compte créé avec succès!</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        AccessAccountBus.$emit('accessaccount_created', newaccessaccount)
                        $('#addUpdateAccessaccount').modal('hide')
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        updateAccessaccount() {
            this.loading = true

            this.revertStatusObject()

            this.accessaccountForm
                .put(`/accessaccounts/${this.accessaccountId}`,undefined)
                .then(updaccessaccount => {
                    this.loading = false
                    this.$swal({
                        html: '<small>Compte modifié avec succès!</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        AccessAccountBus.$emit('accessaccount_updated', updaccessaccount)
                        $('#addUpdateAccessaccount').modal('hide')
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        /**
         * Renvoi le code du statut sélectionné en tant qu'objet au lieu d'un string
         */
        revertStatusObject() {
            this.accessaccountForm.status = {'code': this.accessaccountForm.status}
        }
    },
    computed: {
        isValidCreateForm() {
            return !this.loading
        }
    }
}
</script>
