<template>
    <div class="modal fade" id="addUpdatereportfileaccess" tabindex="-1" role="dialog" aria-labelledby="reportfileaccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="reportfileaccessModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="reportFileAccessForm.errors.clear()">
                        <div class="card-body">
                            <div v-if="editing" class="form-group row">
                                <label for="id" class="col-sm-2 col-form-label text-xs">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="id" v-model="reportfileaccessId" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reportfile" class="col-sm-2 col-form-label text-xs">Fichier</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="reportfile" name="reportfile" placeholder="Fichier" v-model="reportFileAccessForm.reportfile.name" readonly>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileAccessForm.errors.has('reportfile')" v-text="reportFileAccessForm.errors.get('reportfile')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="select_accessaccount" class="col-sm-2 col-form-label text-xs text-xs">Compte</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_accessaccount"
                                        v-model="reportFileAccessForm.accessaccount"
                                        selected.sync="reportFileAccessForm.accessaccount"
                                        value=""
                                        :options="accessaccounts"
                                        :searchable="true"
                                        :multiple="false"
                                        label="login"
                                        track-by="id"
                                        key="id"
                                        placeholder="Compte"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileAccessForm.errors.has('accessaccount')" v-text="reportFileAccessForm.errors.get('accessaccount')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="select_reportserver" class="col-sm-2 col-form-label text-xs text-xs">Serveur</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_reportserver"
                                        v-model="reportFileAccessForm.reportserver"
                                        selected.sync="reportFileAccessForm.reportserver"
                                        value=""
                                        :options="reportservers"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Serveur"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileAccessForm.errors.has('reportserver')" v-text="reportFileAccessForm.errors.get('reportserver')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="select_accessprotocole" class="col-sm-2 col-form-label text-xs text-xs">Protocole</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_accessprotocole"
                                        v-model="reportFileAccessForm.accessprotocole"
                                        selected.sync="reportFileAccessForm.accessprotocole"
                                        value=""
                                        :options="accessprotocoles"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Protocole"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileAccessForm.errors.has('accessprotocole')" v-text="reportFileAccessForm.errors.get('accessprotocole')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reportfile_retrieval_type" class="col-sm-4 col-form-label text-xs">Récupération du Fichier:</label>
                            </div>
                            <div class="form-group row">
                                <label for="reportfile_retrieval_type" class="col-sm-2 col-form-label text-xs">
                                </label>
                                <div class="col-sm-10">
                                    <b-field id="reportfile_retrieval_type" label="" label-position="on-border" custom-class="is-small">
                                        <b-radio-button size="is-small" v-model="reportFileAccessForm.retrieval_type"
                                                        native-value="retrieve_by_name"
                                                        type="is-success is-light is-outlined" @input="retrievalTypeChange($event)">
                                            <span>Par Nom</span>
                                        </b-radio-button>
                                        <b-radio-button size="is-small" v-model="reportFileAccessForm.retrieval_type"
                                                        native-value="retrieve_by_wildcard"
                                                        type="is-warning is-light is-outlined" @input="retrievalTypeChange($event)">
                                            <span>Par Wildcard</span>
                                        </b-radio-button>
                                    </b-field>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10">
                                    <b-field id="status" label="Statut" label-position="on-border" custom-class="is-small">
                                        <b-radio-button size="is-small" v-model="reportFileAccessForm.status"
                                                        native-value="active"
                                                        type="is-success is-light is-outlined">
                                            <b-icon icon="check"></b-icon>
                                            <span>Actif</span>
                                        </b-radio-button>
                                        <b-radio-button size="is-small" v-model="reportFileAccessForm.status"
                                                        native-value="inactive"
                                                        type="is-danger is-light is-outlined">
                                            <b-icon icon="close"></b-icon>
                                            <span>Inactif</span>
                                        </b-radio-button>
                                    </b-field>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Description" v-model="reportFileAccessForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileAccessForm.errors.has('description')" v-text="reportFileAccessForm.errors.get('description')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal" @click="closeModal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateReportFileAccess()" :disabled="!isValidForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createReportFileAccess()" :disabled="!isValidForm" v-else>Créer Nouveau</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import ReportFileAccessBus from "./reportfileaccessBus";

class ReportFileAccess {
    constructor(reportfileaccess) {
        this.reportfile = reportfileaccess.reportfile || {}
        this.accessaccount = reportfileaccess.accessaccount || {}
        this.reportserver = reportfileaccess.reportserver || {}
        this.accessprotocole = reportfileaccess.accessprotocole || {}
        this.description = reportfileaccess.description || ''

        this.retrieve_by_name = reportfileaccess.retrieve_by_name || ''
        this.retrieve_by_wildcard = reportfileaccess.retrieve_by_wildcard || ''
        this.retrieval_type = reportfileaccess.retrieve_by_name ? 'retrieve_by_name' : (reportfileaccess.retrieve_by_wildcard ? 'retrieve_by_wildcard' : 'retrieve_by_name' )

        this.status = reportfileaccess.status ? reportfileaccess.status.code : 'active'

        this.name = reportfileaccess.name ? reportfileaccess.name : null
        this.code = reportfileaccess.code ? reportfileaccess.code : null
    }
}
export default {
    name: "reportfileaccess-addupdate",
    components: { Multiselect },

    mounted() {
        // Se déclenche à la réception de l'évènement 'reportfileaccess_create'
        ReportFileAccessBus.$on('report_file_type_create', (reportfile) => {
            this.editing = false

            this.reportfileaccessUuid = null
            this.reportfileaccessId = null

            this.reportfileaccess = new ReportFileAccess({'reportfile': reportfile})
            this.reportFileAccessForm = new Form(this.reportfileaccess)
            $('#addUpdatereportfileaccess').modal() // rend visible le formulaire.
        })

        // Se déclenche à la réception de l'évènement 'reportfileaccess_edit'
        ReportFileAccessBus.$on('report_file_access_edit', (reportfileaccess) => {
            console.log('report_file_type_edit received on ADDUPDATE: ', reportfileaccess)
            this.editing = true

            this.reportfileaccess = new ReportFileAccess(reportfileaccess)
            //this.reportfileaccesstype_selected = this.getreportfileaccessType(reportfileaccess.type)
            this.reportFileAccessForm = new Form(this.reportfileaccess)

            this.reportfileaccessUuid = reportfileaccess.uuid
            this.reportfileaccessId = reportfileaccess.id
            this.formTitle = 'Modification Accès'

            $('#addUpdatereportfileaccess').modal()
        })
    },

    created() {
        axios.get('/accessaccounts.fetch')
            .then(({data}) => this.accessaccounts = data);

        axios.get('/reportservers.fetch')
            .then(({data}) => this.reportservers = data);

        axios.get('/accessprotocoles.fetch')
            .then(({data}) => this.accessprotocoles = data);
    },

    data() {
        return {
            formTitle: 'Création Accès',
            reportfileaccess: {},
            reportFileAccessForm: new Form(new ReportFileAccess({})),
            reportfileaccessId: null,
            reportfileaccessUuid: null,
            editing: false,
            loading: false,
            accessaccounts: [],
            reportservers: [],
            accessprotocoles: [],
        }
    },

    methods: {
        getreportfileaccessType($type) {
            let typeIndex = this.reportfileaccess.findIndex(s => {
                return $type === s.value
            })
            if (typeIndex !== -1) {
                return this.reportfileaccess[typeIndex]
            } else {
                return null
            }
        },

        createReportFileAccess() {

            this.loading = true

            this.revertStatusObject()

            this.reportFileAccessForm
                .post('/reportfileaccesses')
                .then(reportfileaccess => {

                    this.loading = false

                    this.closeModal();

                    this.$swal({
                        html: '<small>Accès créé avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportFileAccessBus.$emit('report_file_access_created', reportfileaccess)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        updateReportFileAccess() {
            this.loading = true

            this.revertStatusObject()

            this.reportFileAccessForm
                .put(`/reportfileaccesses/${this.reportfileaccessUuid}`,undefined)
                .then(reportfileaccess => {
                    this.loading = false
                    this.resetForm();
                    $('#addUpdatereportfileaccess').modal('hide')
                    this.$swal({
                        html: '<small>Accès mis à jour avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportFileAccessBus.$emit('report_file_access_updated', reportfileaccess)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        closeModal() {
            this.resetForm()
            $('#addUpdatereportfileaccess').modal('hide')
        },
        resetForm() {
            this.reportFileAccessForm.reset();
        },
        revertStatusObject() {
            this.reportFileAccessForm.status = {'code': this.reportFileAccessForm.status}
        },
        retrievalTypeChange(event) {
            this.reportFileAccessForm.retrieval_type = event;
            this.updateRetrievalType();
        },
        updateRetrievalType() {
            if (this.reportFileAccessForm.retrieval_type === 'retrieve_by_name') {
                this.reportFileAccessForm.retrieve_by_name = 1;
                this.reportFileAccessForm.retrieve_by_wildcard = 0;
            } else if (this.reportFileAccessForm.retrieval_type === 'retrieve_by_wildcard') {
                this.reportFileAccessForm.retrieve_by_name = 0;
                this.reportFileAccessForm.retrieve_by_wildcard = 1;
            } else {
                this.reportFileAccessForm.retrieve_by_name = 0;
                this.reportFileAccessForm.retrieve_by_wildcard = 0;
            }
        },
    },

    computed: {
        isValidForm() {
            return !this.loading && !this.reportFileAccessForm.name !== ""
        }
    }
}
</script>

<style scoped>
</style>
