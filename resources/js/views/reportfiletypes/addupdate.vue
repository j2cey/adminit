<template>
    <div class="modal fade" id="addUpdatereportfiletype" tabindex="-1" role="dialog" aria-labelledby="reportfiletypeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-sm" id="reportfiletypeModalLabel">{{ formTitle }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="reportFileTypeForm.errors.clear()">
                        <div class="card-body">
                            <div v-if="editing" class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="id" name="id" placeholder="id" v-model="reportfiletypeId" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label text-xs">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" v-model="reportFileTypeForm.name">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileTypeForm.errors.has('name')" v-text="reportFileTypeForm.errors.get('name')"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="extension" class="col-sm-2 col-form-label text-xs text-xs">Extension</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="extension" name="extension" placeholder="extension" v-model="reportFileTypeForm.extension">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileTypeForm.errors.has('extension')" v-text="reportFileTypeForm.errors.get('extension')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="select_group" class="col-sm-2 col-form-label text-xs text-xs">Mime Type</label>
                                <div class="col-sm-8">
                                    <multiselect
                                        id="select_group"
                                        v-model="reportFileTypeForm.filemimetype"
                                        selected.sync="subjectForm.filemimetype"
                                        value=""
                                        :options="mimetypes"
                                        :searchable="true"
                                        :multiple="false"
                                        label="name"
                                        track-by="id"
                                        key="id"
                                        placeholder="Mime Type"
                                    >
                                    </multiselect>
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileTypeForm.errors.has('filemimetype')" v-text="reportFileTypeForm.errors.get('filemimetype')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label text-xs text-xs">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Description" v-model="reportFileTypeForm.description">
                                    <span class="invalid-feedback d-block text-xs" role="alert" v-if="reportFileTypeForm.errors.has('description')" v-text="reportFileTypeForm.errors.get('description')"></span>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <b-button type="is-dark" size="is-small" data-dismiss="modal" @click="closeModal">Fermer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="updateReportFileType()" :disabled="!isValidForm" v-if="editing">Enregistrer</b-button>
                    <b-button type="is-primary" size="is-small" :loading="loading" @click="createReportFileType()" :disabled="!isValidForm" v-else>Créer Nouveau</b-button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import ReportFileTypeBus from "./reportfiletypeBus";

class ReportFileType {
    constructor(reportfiletype) {
        this.name = reportfiletype.name || ''
        this.extension = reportfiletype.extension || ''
        this.filemimetype = reportfiletype.filemimetype || {}
        this.description = reportfiletype.description || ''
    }
}
export default {
    name: "reportfiletype-addupdate",
    components: { Multiselect },

    mounted() {
        // Se déclenche à la réception de l'évènement 'reportfiletype_create'
        ReportFileTypeBus.$on('report_file_type_create', () => {
            this.editing = false

            this.reportfiletypeUuid = null
            this.reportfiletypeId = null

            this.reportfiletype = new ReportFileType({})
            this.reportFileTypeForm = new Form(this.reportfiletype)
            $('#addUpdatereportfiletype').modal() // rend visible le formulaire.
        })

        // Se déclenche à la réception de l'évènement 'reportfiletype_edit'
        ReportFileTypeBus.$on('report_file_type_edit', (reportfiletype) => {
            console.log('report_file_type_edit received on ADDUPDATE: ', reportfiletype)
            this.editing = true

            this.reportfiletype = new ReportFileType(reportfiletype)
            //this.reportfiletypetype_selected = this.getreportfiletypeType(reportfiletype.type)
            this.reportFileTypeForm = new Form(this.reportfiletype)

            this.reportfiletypeUuid = reportfiletype.uuid
            this.reportfiletypeId = reportfiletype.id
            this.formTitle = 'Modification Type de Fichier'

            $('#addUpdatereportfiletype').modal()
        })
    },

    created() {
        axios.get('/filemimetypes.fetch')
            .then(({data}) => this.mimetypes = data);
    },

    data() {
        return {
            formTitle: 'Création Type de Fichier',
            reportfiletype: {},
            reportFileTypeForm: new Form(new ReportFileType({})),
            reportfiletypeId: null,
            reportfiletypeUuid: null,
            editing: false,
            loading: false,
            mimetypes: [],
        }
    },

    methods: {
        getreportfiletypeType($type) {
            let typeIndex = this.reportfiletype.findIndex(s => {
                return $type === s.value
            })
            if (typeIndex !== -1) {
                return this.reportfiletype[typeIndex]
            } else {
                return null
            }
        },

        createReportFileType() {

            this.loading = true

            this.reportFileTypeForm
                .post('/reportfiletypes')
                .then(reportfiletype => {

                    this.loading = false

                    this.closeModal();

                    this.$swal({
                        html: '<small>Type de fichier créé avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportFileTypeBus.$emit('report_file_type_created', reportfiletype)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        updateReportFileType() {
            this.loading = true
            this.reportFileTypeForm
                .put(`/reportfiletypes/${this.reportfiletypeUuid}`)
                .then(reportfiletype => {
                    this.loading = false
                    this.resetForm();
                    $('#addUpdatereportfiletype').modal('hide')
                    this.$swal({
                        html: '<small>Type de fichier mis à jour avec succès !</small>',
                        icon: 'success',
                        timer: 3000
                    }).then(() => {
                        ReportFileTypeBus.$emit('report_file_type_updated', reportfiletype)
                    })
                }).catch(error => {
                this.loading = false
            });
        },
        closeModal() {
            this.resetForm()
            $('#addUpdatereportfiletype').modal('hide')
        },
        resetForm() {
            this.reportFileTypeForm.reset();
        }
    },

    computed: {
        isValidForm() {
            return !this.loading && !this.reportFileTypeForm.name !== ""
        }
    }
}
</script>

<style scoped>
</style>
