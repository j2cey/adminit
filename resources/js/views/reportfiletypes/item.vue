<template>
    <div class="row">
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left">{{ reportfiletype.id }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-sm d-inline-block text-truncate text-sm-left" style="max-width: 100%;">{{ reportfiletype.name }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">{{ reportfiletype.extension }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs">{{ reportfiletype.filemimetype ? reportfiletype.filemimetype.name : '' }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <a @click="editReportFileType(reportfiletype)" class="text text-success">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <a type="button"  @click="deleteReportFileType(reportfiletype)" class="btn btn-tool text-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import ReportFileTypeBus from "./reportfiletypeBus";

export default {
    name: "reportfiletype-item",

    props: {
        reportfiletype_prop: {}
    },

    components: {
    },
    mounted() {
        ReportFileTypeBus.$on('report_file_type_updated', (reportfiletype) => {
            if (this.reportfiletype.id === reportfiletype.id) {
                this.reportfiletype = reportfiletype
            }
        })
    },
    data() {
        return {
            reportfiletype: this.reportfiletype_prop,
        };
    },
    methods: {
        editReportFileType(reportfiletype) {
            console.log('report_file_type_edit on ITEM: ', reportfiletype)
            ReportFileTypeBus.$emit('report_file_type_edit', reportfiletype);
        },

        deleteReportFileType(reportfiletype) {

            this.$swal({
                title: '<small>Êtes vous sûr de vouloir supprimer ce fichier?</small>',
                text: "Vous ne pourrez plus le récupérer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimez le!',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.value) {

                    // eslint-disable-next-line no-undef
                    axios.delete(`/reportfiletypes/${reportfiletype.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.$swal({
                                html: '<small>Type de Fichier supprimé avec succès</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('reportfiletype_deleted', reportfiletype)
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })

                }
            })
        },

    },
    computed: {
    }
}
</script>

<style scoped>

</style>
