<template>
    <div class="modal fade" id="addUpdateosserver" tabindex="-1" role="dialog" aria-labelledby="osserverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="osserverModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="osServerForm.errors.clear()">
                        <div class="card-body">
                            <div v-if="editing" class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="id" v-model="osserverId" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" v-model="osServerForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="osServerForm.errors.has('name')" v-text="osServerForm.errors.get('name')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="select_osfamily" class="col-sm-2 col-form-label text-xs text-xs">Famille</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_osfamily"
                                        v-model="osServerForm.osfamily"
                                        selected.sync="subjectForm.osfamily"
                                        value=""
                                        :options="osfamilies"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Famille"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="osServerForm.errors.has('osfamily')" v-text="osServerForm.errors.get('osfamily')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="select_group" class="col-sm-2 col-form-label text-xs text-xs">Famille</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_group"
                                        v-model="osServerForm.osfamily"
                                        selected.sync="subjectForm.osfamily"
                                        value=""
                                        :options="osfamilies"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Famille"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="osServerForm.errors.has('osfamily')" v-text="osServerForm.errors.get('osfamily')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="osarchitecture" class="col-sm-2 col-form-label text-xs">Architecture</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="osarchitecture" name="osarchitecture" placeholder="Architecture" v-model="osServerForm.osarchitecture">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="osServerForm.errors.has('osarchitecture')" v-text="osServerForm.errors.get('osarchitecture')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal" @click="closeModal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateOsServer()" :disabled="!isValidForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createOsServer()" :disabled="!isValidForm" v-else>Créer Nouveau</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import OsServerBus from "./osserverBus";

class OsServer {
    constructor(osserver) {
        this.name = osserver.name || ''
        this.osfamily = osserver.osfamily || ''
        this.osarchitecture = osserver.osarchitecture || ''
        this.description = osserver.description || ''
    }
}
export default {
    name: "osserver-addupdate",
    components: { Multiselect },

    mounted() {
        // Se déclenche à la réception de l'évènement 'osserver_create'
        OsServerBus.$on('os_server_create', () => {
            this.editing = false

            this.osserverUuid = null
            this.osserverId = null

            this.osserver = new OsServer({})
            this.osServerForm = new Form(this.osserver)
            $('#addUpdateosserver').modal() // rend visible le formulaire.
        })

        // Se déclenche à la réception de l'évènement 'osserver_edit'
        OsServerBus.$on('os_server_edit', (osserver) => {
            console.log('os_server_edit received on ADDUPDATE: ', osserver)
            this.editing = true

            this.osserver = new OsServer(osserver)
            //this.osservert_selected = this.getosserver(osserver)
            this.osServerForm = new Form(this.osserver)

            this.osserverUuid = osserver.uuid
            this.osserverId = osserver.id
            this.formTitle = 'Modification du server'

            $('#addUpdateosserver').modal()
        })
    },

    created() {

    },

    data() {
        return {
            formTitle: 'Création du server ',
            osserver: {},
            osServerForm: new Form(new OsServer({})),
            osserverId: null,
            osserverUuid: null,
            editing: false,
            loading: false,
            osfamilies: [],
        }
    },

    methods: {
        getosserverType($type) {
            let typeIndex = this.osserver.findIndex(s => {
                return $type === s.value
            })
            if (typeIndex !== -1) {
                return this.osserver[typeIndex]
            } else {
                return null
            }
        },

        createOsServer() {

            this.loading = true

            this.osServerForm
                .post('/osservers')
                .then(osserver => {

                    this.loading = false

                    this.closeModal();

                    this.$swal({
                        html: '<small>Serveur créé avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        OsServerBus.$emit('os_server_created', osserver)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        updateOsServer() {
            this.loading = true
            this.osServerForm
                .put(`/osservers/${this.osserverUuid}`)
                .then(osserver => {
                    this.loading = false
                    this.resetForm();
                    $('#addUpdateosserver').modal('hide')
                    this.$swal({
                        html: '<small>Serveur mis à jour avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        OsServerBus.$emit('os_server_updated', osserver)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        closeModal() {
            this.resetForm()
            $('#addUpdateosserver').modal('hide')
        },
        resetForm() {
            this.osServerForm.reset();
        }
    },

    computed: {
        isValidForm() {
            return !this.loading && !this.osServerForm.name !== ""
        }
    }
}
</script>

<style scoped>
</style>
