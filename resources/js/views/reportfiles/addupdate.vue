<template>
    <div class="modal fade" id="addUpdateReportfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="reportfileModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="reportfileForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="reportfile_name" class="col-sm-2 col-form-label text-xs">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="reportfile_name" name="name" autocomplete="name" autofocus placeholder="Nom" v-model="reportfileForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportfileForm.errors.has('name')" v-text="reportfileForm.errors.get('name')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reportfile_wildcard" class="col-sm-2 col-form-label text-xs">Wildcard</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control text-xs" id="reportfile_wildcard" name="wildcard" autocomplete="wildcard" autofocus placeholder="Wildcard" v-model="reportfileForm.wildcard">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportfileForm.errors.has('wildcard')" v-text="reportfileForm.errors.get('wildcard')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reportfile_wildcard" class="col-sm-4 col-form-label text-xs">Récupération du Fichier:</label>
                            </div>
                            <div class="form-group row">
                                <label for="reportfile_wildcard" class="col-sm-2 col-form-label text-xs">
                                </label>
                                <div class="col-sm-10">
                                    <b-field label="" label-position="on-border" custom-class="is-small">
                                        <b-radio-button size="is-small" v-model="reportfileForm.retrieval_type"
                                                        native-value="retrieve_by_name"
                                                        type="is-success is-light is-outlined" @input="retrievalTypeChange($event)">
                                            <span>Par Nom</span>
                                        </b-radio-button>
                                        <b-radio-button size="is-small" v-model="reportfileForm.retrieval_type"
                                                        native-value="retrieve_by_wildcard"
                                                        type="is-warning is-light is-outlined" @input="retrievalTypeChange($event)">
                                            <span>Par Wildcard</span>
                                        </b-radio-button>
                                    </b-field>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="m_select_reportfiletype" class="col-sm-2 col-form-label text-xs">Type du Fichier</label>
                                <div class="col-sm-10 text-xs">
                                    <multiselect class="text text-xs"
                                         id="m_select_reportfiletype"
                                         v-model="reportfileForm.reportfiletype"
                                         selected.sync="reportfileForm.reportfiletype"
                                         value=""
                                         :options="reportfiletypes"
                                         :searchable="true"
                                         :multiple="false"
                                         label="name"
                                         track-by="id"
                                         key="id"
                                         placeholder="Type du Fichier"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportfileForm.errors.has('reportfiletype')" v-text="reportfileForm.errors.get('reportfiletype')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs">Statut</label>
                                <div class="col-sm-10">
                                    <b-field label="Statut" label-position="on-border" custom-class="is-small">
                                        <b-radio-button size="is-small" v-model="reportfileForm.status"
                                                        native-value="active"
                                                        type="is-success is-light is-outlined">
                                            <b-icon icon="check"></b-icon>
                                            <span>Actif</span>
                                        </b-radio-button>
                                        <b-radio-button size="is-small" v-model="reportfileForm.status"
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
                                    <input @keyup.enter="formKeyEnter()" type="text" class="form-control text-xs" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="reportfileForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportfileForm.errors.has('description')" v-text="reportfileForm.errors.get('description')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateReportfile()" :disabled="!isValidCreateForm" v-if="editing">Enregister</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createReportfile()" :disabled="!isValidCreateForm" v-else>Créer un fichier</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

import ReportFileBus from "./reportfileBus";

class Reportfile {
    constructor(reportfile) {
        this.name = reportfile.name || ''
        this.wildcard = reportfile.wildcard || ''
        this.retrieve_by_name = reportfile.retrieve_by_name || ''
        this.retrieve_by_name_label = reportfile.retrieve_by_name_label || ''
        this.retrieve_by_wildcard = reportfile.retrieve_by_wildcard || ''
        this.retrieve_by_wildcard_label = reportfile.retrieve_by_wildcard_label || ''
        this.description = reportfile.description || ''

        // Attribu interne pour la gestion des radioButtons 'retrieve_by_name' et 'retrieve_by_wildcard'
        this.retrieval_type = reportfile.retrieve_by_name ? 'retrieve_by_name' : (reportfile.retrieve_by_wildcard ? 'retrieve_by_wildcard' : 'retrieve_by_name' )

        this.reportfiletype = reportfile.reportfiletype || {}
        this.status = reportfile.status ? reportfile.status.code : 'active'
        this.report = reportfile.report || {}
    }
}
export default {
    name: "reportfile-addupdate",
    props: {
    },
    components: { Multiselect },
    mounted() {

        ReportFileBus.$on('create_new_reportfile', ({ report }) => {
            this.editing = false
            this.reportfile = new Reportfile({'report': report})
            this.reportfileForm = new Form(this.reportfile)

            this.formTitle = 'Créer un nouveau fichier'

            $('#addUpdateReportfile').modal()
        })

        ReportFileBus.$on('edit_reportfile', ({ reportfile }) => {
            this.editing = true
            this.reportfile = new Reportfile(reportfile)
            this.reportfileForm = new Form(this.reportfile)
            this.reportfileId = reportfile.uuid

            this.formTitle = 'Modification du fichier'

            $('#addUpdateReportfile').modal()
        })
    },
    created() {
        axios.get('/reportfiletypes.fetch')
            .then(({data}) => this.reportfiletypes = data);
    },
    data() {
        return {
            formTitle: 'Création d"un fichier',
            reportfile: {},
            reportfileForm: new Form(new Reportfile({})),
            reportfileId: null,
            editing: false,
            loading: false,
            reportfiletypes: []
        }
    },
    methods: {
        formKeyEnter() {
            if (this.editing) {
                this.updateReportfile()
            } else {
                this.createReportfile()
            }
        },
        createReportfile() {
            this.loading = true

            this.revertStatusObject()

            this.reportfileForm
                .post('/reportfiles')
                .then(newreportfile => {
                    this.loading = false
                    this.$swal({
                        html: '<small>Fichier créé avec succès!</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportFileBus.$emit('reportfile_created', newreportfile)
                        $('#addUpdateReportfile').modal('hide')
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        updateReportfile() {
            this.loading = true

            this.revertStatusObject()

            this.reportfileForm
                .put(`/reportfiles/${this.reportfileId}`,undefined)
                .then(updreportfile => {
                    this.loading = false
                    this.$swal({
                        html: '<small>Fichier modifié avec succès!</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportFileBus.$emit('reportfile_updated', updreportfile)
                        $('#addUpdateReportfile').modal('hide')
                    })

                }).catch(error => {
                this.loading = false
            });
        },

        retrievalTypeChange(event) {
            this.reportfileForm.retrieval_type = event;
            this.updateRetrievalType();
        },
        updateRetrievalType() {
            if (this.reportfileForm.retrieval_type === 'retrieve_by_name') {
                this.reportfileForm.retrieve_by_name = 1;
                this.reportfileForm.retrieve_by_wildcard = 0;
            } else if (this.reportfileForm.retrieval_type === 'retrieve_by_wildcard') {
                this.reportfileForm.retrieve_by_name = 0;
                this.reportfileForm.retrieve_by_wildcard = 1;
            } else {
                this.reportfileForm.retrieve_by_name = 0;
                this.reportfileForm.retrieve_by_wildcard = 0;
            }
        },
        /**
         * Renvoi le code du statut sélectionné en tant qu'objet au lieu d'un string
         */
        revertStatusObject() {
            this.reportfileForm.status = {'code': this.reportfileForm.status}
        }
    },
    computed: {
        isValidCreateForm() {
            return !this.loading
        }
    }
}
</script>
