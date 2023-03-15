<template>
    <div class="modal fade" id="addUpdateReportserver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="reportserverModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="reportserverForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="reportserver_name" class="col-sm-4 col-form-label text-xs">Nom</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-xs" id="reportserver_name" name="name" autocomplete="name" autofocus placeholder="Nom" v-model="reportserverForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportserverForm.errors.has('name')" v-text="reportserverForm.errors.get('name')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="select_osserver" class="col-sm-4 col-form-label text-xs text-xs">Système d'exploitation</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_osserver"
                                        v-model="reportserverForm.osserver"
                                        selected.sync="subjectForm.osserver"
                                        value=""
                                        :options="osservers"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Operatin System"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportserverForm.errors.has('osserver')" v-text="reportserverForm.errors.get('osserver')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reportserver_domain_name" class="col-sm-4 col-form-label text-xs">Nom du domaine</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-xs" id="reportserver_domain_name" name="domain_name" autocomplete="domain_name" autofocus placeholder="Nom du domaine" v-model="reportserverForm.domain_name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportserverForm.errors.has('domain_name')" v-text="reportserverForm.errors.get('domain_name')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="reportserver_ip_address" class="col-sm-4 col-form-label text-xs">Adresse IP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-xs" id="reportserver_ip_address" name="ip_address" autocomplete="ip_address" autofocus placeholder="Adresse IP" v-model="reportserverForm.ip_address">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportserverForm.errors.has('ip_address')" v-text="reportserverForm.errors.get('ip_address')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-xs">  Statut  </label>
                                <div class="col-sm-8">
                                    <b-field label="Statut" label-position="on-border" custom-class="is-small">
                                        <b-radio-button size="is-small" v-model="reportserverForm.status"
                                                        native-value="active"
                                                        type="is-success is-light is-outlined">
                                            <b-icon icon="check"></b-icon>
                                            <span>Actif</span>
                                        </b-radio-button>
                                        <b-radio-button size="is-small" v-model="reportserverForm.status"
                                                        native-value="inactive"
                                                        type="is-danger is-light is-outlined">
                                            <b-icon icon="close"></b-icon>
                                            <span>Inactif</span>
                                        </b-radio-button>
                                    </b-field>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="description" class="col-sm-4 col-form-label text-xs">Description</label>
                                <div class="col-sm-8">
                                    <input @keyup.enter="formKeyEnter()" type="text" class="form-control text-xs" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="reportserverForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportserverForm.errors.has('description')" v-text="reportserverForm.errors.get('description')"></span>
                                </div>
                            </div>

                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateReportserver()" :disabled="!isValidCreateForm" v-if="editing">Enregister</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createReportserver()" :disabled="!isValidCreateForm" v-else>Créer le serveur</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

import Multiselect from 'vue-multiselect';
import ReportServerBus from "../reportservers/reportserverBus";

class Reportserver {
    constructor(reportserver) {
        this.name = reportserver.name || ''
        this.osserver = reportserver.osserver || ''
        this.ip_address = reportserver.ip_address || ''
        this.domain_name = reportserver.domain_name || ''
        this.description = reportserver.description || ''

        this.status = reportserver.status ? reportserver.status.code : 'active'
    }
}
export default {
    name: "reportserver-addupdate",
    props: {
    },
    components: { Multiselect },
    mounted() {

        ReportServerBus.$on('create_new_reportserver', () => {
            this.editing = false
            this.reportserver = new Reportserver({})
            this.reportserverForm = new Form(this.reportserver)

            this.formTitle = 'Créer un nouveau serveur'

            $('#addUpdateReportserver').modal()
        })

        ReportServerBus.$on('edit_reportserver', ({ reportserver }) => {
            this.editing = true
            this.reportserver = new Reportserver(reportserver)
            this.reportserverForm = new Form(this.reportserver)
            this.reportserverId = reportserver.uuid

            this.formTitle = 'Modification du serveur'

            $('#addUpdateReportserver').modal()
        })
    },
    created() {
        axios.get('/osservers.fetch')
            .then(({data}) => this.osservers = data);
    },
    data() {
        return {
            formTitle: 'Créer un nouveau serveur',
            reportserver: {},
            reportserverForm: new Form(new Reportserver({})),
            reportserverId: null,
            reportserverUuid: null,
            editing: false,
            loading: false,
            osservers: [],
        }
    },
    methods: {
        formKeyEnter() {
            if (this.editing) {
                this.updateReportserver()
            } else {
                this.createReportserver()
            }
        },
        createReportserver() {
            this.loading = true

            this.revertStatusObject()

            this.reportserverForm
                .post('/reportservers')
                .then(newreportserver => {
                    this.loading = false
                    this.$swal({
                        html: '<small>Serveur créé avec succès!</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportServerBus.$emit('reportserver_created', newreportserver)
                        $('#addUpdateReportserver').modal('hide')
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        updateReportserver() {
            this.loading = true

            this.revertStatusObject()

            this.reportserverForm
                .put(`/reportservers/${this.reportserverId}`,undefined)
                .then(updreportserver => {
                    this.loading = false
                    this.$swal({
                        html: '<small>Serveur modifié avec succès!</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportServerBus.$emit('reportserver_updated', updreportserver)
                        $('#addUpdateReportserver').modal('hide')
                    })

                }).catch(error => {
                this.loading = false
            });
        },
        /**
         * Renvoi le code du statut sélectionné en tant qu'objet au lieu d'un string
         */
        revertStatusObject() {
            this.reportserverForm.status = {'code': this.reportserverForm.status}
        }
    },
    computed: {
        isValidCreateForm() {
            return !this.loading
        }
    }
}
</script>
