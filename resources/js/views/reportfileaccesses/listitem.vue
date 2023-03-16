<template>
    <div class="row">
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs d-inline-block text-truncate text-xs-left">{{ reportfileaccess.accessaccount ? reportfileaccess.accessaccount.login : '' }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 col-6 border-right">
            <span class="text text-xs d-inline-block text-truncate text-xs-left" style="max-width: 100%;">{{ reportfileaccess.reportserver ? reportfileaccess.reportserver.ip_address : '' }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">{{ reportfileaccess.accessprotocole ? reportfileaccess.accessprotocole.name : '' }}</span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6 border-right">
            <span class="text text-xs">
                <b-tag type="is-success is-light" v-if="reportfileaccess.status && reportfileaccess.status.code === 'active'">{{ reportfileaccess.status.name }}</b-tag>
                <b-tag type="is-success is-light" v-else-if="reportfileaccess.status && reportfileaccess.status.code === 'inactive'">{{ reportfileaccess.status.name }}</b-tag>
                <b-tag icon="account-check-outline" v-else>PB status</b-tag>
            </span>
        </div>
        <!-- /.col -->
        <div class="col-sm-2 col-6">
            <span class="text text-xs text-center">
                <div class="block">
                    <a @click="editReportFileAccess(reportfileaccess)" class="tw-inline-block tw-mr-3 text-warning">
                        <b-icon
                            pack="fas"
                            icon="pencil-square-o"
                            size="is-small">
                        </b-icon>
                    </a>
                    <a @click="deleteReportFileAccess(reportfileaccess)" class="tw-inline-block tw-mr-3 text-danger">
                        <b-icon
                            pack="fas"
                            icon="trash"
                            size="is-small">
                        </b-icon>
                    </a>
                </div>
            </span>
        </div>

    </div>
    <!-- /.row -->
</template>

<script>
import ReportFileAccessBus from "../reportfileaccesses/reportfileaccessBus";

export default {
    name: "reportfileaccess-listitem",

    props: {
        reportfileaccess_prop: {}
    },

    components: {
    },
    mounted() {
        ReportFileAccessBus.$on('report_file_access_updated', (reportfileaccess) => {
            if (this.reportfileaccess.id === reportfileaccess.id) {
                this.reportfileaccess = reportfileaccess
            }
        })
    },
    data() {
        return {
            reportfileaccess: this.reportfileaccess_prop,
        };
    },
    methods: {
        editReportFileAccess(reportfileaccess) {
            console.log('report_file_access_edit launched ITEM: ', reportfileaccess)
            ReportFileAccessBus.$emit('report_file_access_edit', reportfileaccess);
        },

        deleteReportFileAccess(reportfileaccess) {

            this.$swal({
                title: '<small>Êtes vous sûr de vouloir supprimer cet Accès ?</small>',
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
                    axios.delete(`/reportfileaccesses/${reportfileaccess.uuid}`)
                        // eslint-disable-next-line no-unused-vars
                        .then(resp => {
                            this.$swal({
                                html: '<small>Accès supprimé avec succès</small>',
                                icon: 'success',
                                timer: 3000
                            }).then(() => {
                                this.$emit('report_file_access_deleted', reportfileaccess)
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
