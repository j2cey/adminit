<template>
    <div class="card card-default">
        <div class="card-header">
            <div class="form-inline float-left">
                <span class="help-inline pr-1 text-sm"> List of Reports in the System </span>
                <b-button size="is-small" type="is-info is-light" @click="createNewReport()"><i class="fas fa-plus"></i></b-button>
            </div>

            <div class="card-tools">

                <div class="input-group input-group-sm" style="width: 150px;">
                    <!--<input type="text" name="table_search" class="form-control float-right" placeholder="Search">-->

                    <!--<div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>-->
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="reportlist">

                <ReportItem v-for="(report, index) in reports" :key="report.id" :report_prop="report" :index_prop="index"></ReportItem>

            </div>
        </div>
        <!-- /.card-body -->
        <AddUpdateWorflow></AddUpdateWorflow>
    </div>
    <!-- /.card -->
</template>

<script>
    import AddUpdateWorflow from './addupdate'

    export default {
        name: "reports-index",
        mounted() {
            this.$on('new_report_created', (report) => {
                window.noty({
                    message: 'Report créé avec succès',
                    type: 'success'
                })
                // insert the just created report in the reports list
                this.reports.push(report)
            })
        },
        components: {
            ReportItem: () => import('../reports/item'),
            AddUpdateWorflow
        },
        data() {
            return {
                reports: []
            }
        },
        created() {
            axios.get('/reports.fetch')
                .then(({data}) => this.reports = data);
        },
        methods: {
            createNewReport() {
                this.$emit('create_new_report')
            },
            createNewStep(report) {
                axios.get(`/reportsteps.fetchbyreport/${report.id}`)
                    .then((resp => {
                        this.$emit('reportstep_create', report, resp.data)
                    }));
            },
            deleteReport(id, key) {
                if(confirm('Voulez-vous vraiment supprimer ?')) {
                    axios.delete(`/reports/${id}`)
                        .then(resp => {
                            this.reports.splice(key, 1)
                            window.noty({
                                message: 'Campagne supprimée avec succès',
                                type: 'success'
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
