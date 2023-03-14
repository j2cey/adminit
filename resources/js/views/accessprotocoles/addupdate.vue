<template>
    <div class="modal fade" id="addUpdateaccessprotocole" tabindex="-1" role="dialog" aria-labelledby="accessprotocoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="accessprotocoleModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="accessProtocoleForm.errors.clear()">
                        <div class="card-body">
                            <div v-if="editing" class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="id" v-model="accessprotocoleId" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" v-model="accessProtocoleForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessProtocoleForm.errors.has('name')" v-text="accessProtocoleForm.errors.get('name')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Description" v-model="accessProtocoleForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="accessProtocoleForm.errors.has('description')" v-text="accessProtocoleForm.errors.get('description')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal" @click="closeModal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateAccessProtocole()" :disabled="!isValidForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createAccessProtocole()" :disabled="!isValidForm" v-else>Créer Nouveau</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import AccessProtocoleBus from "./accessprotocoleBus";

class AccessProtocole {
    constructor(accessprotocole) {
        this.name = accessprotocole.name || ''
        this.description = accessprotocole.description || ''
    }
}
export default {
    name: "accessprotocole-addupdate",

    mounted() {
        // Se déclenche à la réception de l'évènement 'accessprotocole_create'
        AccessProtocoleBus.$on('access_protocole_create', () => {
            this.editing = false

            this.accessprotocoleUuid = null
            this.accessprotocoleId = null

            this.accessprotocole = new AccessProtocole({})
            this.accessProtocoleForm = new Form(this.accessprotocole)
            $('#addUpdateaccessprotocole').modal() // rend visible le formulaire.
        })

        // Se déclenche à la réception de l'évènement 'accessprotocole_edit'
        AccessProtocoleBus.$on('access_protocole_edit', (accessprotocole) => {
            console.log('access_protocole_edit received on ADDUPDATE: ', accessprotocole)
            this.editing = true

            this.accessprotocole = new AccessProtocole(accessprotocole)
            //this.accessprotocolet_selected = this.getaccessprotocole(accessprotocole)
            this.accessProtocoleForm = new Form(this.accessprotocole)

            this.accessprotocoleUuid = accessprotocole.uuid
            this.accessprotocoleId = accessprotocole.id
            this.formTitle = 'Modification du protocole'

            $('#addUpdateaccessprotocole').modal()
        })
    },

    created() {

    },

    data() {
        return {
            formTitle: 'Création du protocole ',
            accessprotocole: {},
            accessProtocoleForm: new Form(new AccessProtocole({})),
            accessprotocoleId: null,
            accessprotocoleUuid: null,
            editing: false,
            loading: false,
            mimetypes: [],
        }
    },

    methods: {
        getaccessprotocoleType($type) {
            let typeIndex = this.accessprotocole.findIndex(s => {
                return $type === s.value
            })
            if (typeIndex !== -1) {
                return this.accessprotocole[typeIndex]
            } else {
                return null
            }
        },

        createAccessProtocole() {

            this.loading = true

            this.accessProtocoleForm
                .post('/accessprotocoles')
                .then(accessprotocole => {

                    this.loading = false

                    this.closeModal();

                    this.$swal({
                        html: '<small>Protocole créé avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        AccessProtocoleBus.$emit('access_protocole_created', accessprotocole)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        updateAccessProtocole() {
            this.loading = true
            this.accessProtocoleForm
                .put(`/accessprotocoles/${this.accessprotocoleUuid}`)
                .then(accessprotocole => {
                    this.loading = false
                    this.resetForm();
                    $('#addUpdateaccessprotocole').modal('hide')
                    this.$swal({
                        html: '<small>Protocole mis à jour avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        AccessProtocoleBus.$emit('access_protocole_updated', accessprotocole)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        closeModal() {
            this.resetForm()
            $('#addUpdateaccessprotocole').modal('hide')
        },
        resetForm() {
            this.accessProtocoleForm.reset();
        }
    },

    computed: {
        isValidForm() {
            return !this.loading && !this.accessProtocoleForm.name !== ""
        }
    }
}
</script>

<style scoped>
</style>
