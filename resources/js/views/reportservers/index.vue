<template>
    <ReportServerList :reportservers_prop="reportservers"></ReportServerList>
</template>

<script>

export default {
    props: {
        reportservers_prop: {}
    },
    name: "report-server-index",
    components: {
        ReportServerList: () => import('../reportservers/list'),
    },
    data() {
        return {
            reportservers: this.reportservers_prop,
        };
    },
}
</script>

<style scoped>

</style>
