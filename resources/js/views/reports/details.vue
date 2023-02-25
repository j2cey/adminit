<template>
    <ReportItem :key="report.id" :report_prop="report" :index_prop="0"></ReportItem>
</template>

<script>

    export default {
        name: "reports-details",
        props: {
            report_prop: {},
        },
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
        },
        data() {
            return {
                report: this.report_prop,
            }
        },
        created() {

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
