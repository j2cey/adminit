<template>
    <div>
        <div class="card">
            <header>
                <div class="card-header-title row">
                    <div class="col-md-6 col-sm-8 col-12">
                            <span class="text-olive text-lg">
                                {{ report.title }}
                            </span>
                    </div>
                    <div class="col-md-6 col-sm-4 col-12 text-right">
                            <span class="text text-sm">
                                <a type="button" class="btn btn-tool text-success" data-toggle="tooltip" @click="showFlowchart(report)">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editReport(report)">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a type="button" class="btn btn-tool text-danger" @click="deleteReport(report.uuid, index)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </span>
                    </div>
                </div>
                <!-- /.user-block -->
            </header>
            <!-- /.card-header -->
            <div class="card-body">
                <dt class="text text-xs">Name</dt>
                <dd class="text text-xs">{{ report.reporttype.name }}</dd>
                <dt class="text text-xs">Description</dt>
                <dd class="text text-xs">{{ report.description }}</dd>
                <dt class="text text-xs">Created at</dt>
                <dd class="text text-xs">{{ report.created_at | formatDate}}</dd>
                <dd class="col-sm-8 offset-sm-4 text-xs"></dd>
            </div>
            <!-- /.card-body -->
        </div>

        <div :id="'reportwrapper_' + report.uuid">
            <div class="card">
                <header>
                    <div class="card-header-title row">
                        <div class="col-md-6 col-sm-8 col-12">
                            <span class="text-purple text-sm" @click="collapseClicked()" data-toggle="collapse" :data-parent="'#reportwrapper_' + report.uuid" :href="'#collapse-reports-'+index">
                                Report Fields
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-4 col-12 text-right">
                            <span class="text text-sm">
                                <a type="button" class="btn btn-tool text-success" data-toggle="tooltip" @click="showFlowchart(report)">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a type="button" class="btn btn-tool text-warning" data-toggle="tooltip" @click="editReport(report)">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a type="button" class="btn btn-tool" @click="collapseClicked()" data-toggle="collapse" :data-parent="'#reportwrapper_' + report.uuid" :href="'#collapse-reports-'+index">
                                    <i :class="currentCollapseIcon"></i>
                                </a>
                                <a type="button" class="btn btn-tool text-danger" @click="deleteReport(report.uuid, index)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                    <!-- /.user-block -->
                </header>
                <!-- /.card-header -->
                <div :id="'collapse-reports-'+index" class="card-content panel-collapse collapse in">

                    <div class="row">

                        <div class="col-md-12 col-sm-6 col-12">

                            <ReportAttributes :report_prop="report" :reportattributes_prop="report.attributes"></ReportAttributes>

                        </div>
                        <!-- /.col -->
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <AddUpdateReport></AddUpdateReport>
    </div>
</template>

<script>
    import ReportAttributes from "../reportattributes/list";
    import AddUpdateReport from "./addupdate";

    import ReportBus from "./reportBus";

    export default {
        name: "report-item",
        props: {
            report_prop: {},
            index_prop: {}
        },
        components: {
            AddUpdateReport,
            ReportAttributes
        },
        mounted() {
            ReportBus.$on('report_updated', (updreport) => {
                if (this.report.id === updreport.id) {
                    this.report = updreport
                    window.noty({
                        message: 'Report successfully updated',
                        type: 'success'
                    })
                }
            })
        },
        created() {

        },
        data() {
            return {
                report: this.report_prop,
                index: this.index_prop,
                collapse_icon: 'fas fa-chevron-down'
            }
        },
        methods: {
            editReport(report) {
                ReportBus.$emit('edit_report', { report })
            },
            showFlowchart(report) {
                /*ReportBus.$emit('show_flowchart', report)*/
                window.location = '/reports.flowchart/' + report.uuid
            },
            deleteReport(id, key) {
                this.$swal({
                    html: '<small>Do you really want to delete this Report ?</small>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if(result.value) {

                        axios.delete(`/reports/${id}`)
                            .then(resp => {

                                console.log('report delete resp: ', resp)

                                this.$swal({
                                    html: '<small>Report successfully deleted !</small>',
                                    icon: 'success',
                                    timer: 3000
                                }).then(() => {
                                    ReportBus.$emit('reportaction_deleted', {key, resp})
                                })
                            }).catch(error => {
                            window.handleErrors(error)
                        })

                    } else {
                        // stay here
                    }
                })
            },
            collapseClicked() {
                if (this.collapse_icon === 'fas fa-chevron-down') {
                    this.collapse_icon = 'fas fa-chevron-up';
                } else {
                    this.collapse_icon = 'fas fa-chevron-down';
                }
            }
        },
        computed: {
            currentCollapseIcon() {
                return this.collapse_icon;
            }
        }
    }
</script>

<style scoped>

</style>
